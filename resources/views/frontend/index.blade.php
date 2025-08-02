<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>QR Code Generator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- QRCode.js -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <!-- html2pdf.js -->
    <script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Sarabun:wght@400;700&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
        }

        #printArea {
            font-family: 'Roboto', sans-serif;
        }

        /* สำหรับหัวกระดาษ */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
            padding-bottom: 0;
            gap: 20px;
        }

        .header .logo {
            width: 60px;
            height: auto;
        }

        .header .title {
            font-size: 20pt;
            font-weight: bold;
            margin: 0;
        }

        #qrCodeContainer {
            display: grid;
            grid-template-columns: repeat(2, 2.75in);

            gap: 0.2in;
            /*  ลดช่องว่างระหว่างคอลัมน์และแถว */
            justify-content: center;
            /*  จัดให้อยู่ตรงกลางหน้ากระดาษ */
            margin-top: 0;

            padding-top: 0.05in;
            /* ลด padding ด้านบนลงให้ชิด header */
            box-sizing: border-box;
        }

        .qr-item {
            width: 2.75in;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .qr-border {
            border: 0.2mm solid #000;
            width: 2.75in;
            height: 2.4in;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.1in;
        }

        .qr-border img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            /* ทำให้ภาพพอดีในกรอบโดยไม่ crop */
            padding: 0;
            /* ลบ padding ถ้ามี */
            margin: 0;
        }

        .store-name {
            font-size: 9pt;
            margin-bottom: 1px;
        }

        .part-no {
            font-size: 9pt;
            font-weight: bold;
        }

        .pac-qty {
            font-size: 9pt;
            font-weight: bold;
        }

        #printArea .header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            margin-bottom: 10px;
        }
    </style>




</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="shadow-sm card">
                    <div class="text-white card-header bg-primary d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-qr-code-scan me-2"></i>QR Code Generator
                        </h4>
                        {{-- <span id="qrCount" class="px-3 py-2 badge bg-light text-dark rounded-pill">
                            Selected: 0
                        </span> --}}
                    </div>

                    <div class="card-body">
                        <div class="row g-5">
                            <!-- Input Section -->
                            <div class="col-lg-5">
                                <h5 class="mb-4"><i class="bi bi-ui-checks-grid me-2"></i>Input Data</h5>
                                <form id="qrForm">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">Store Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                            <select class="form-select" id="storeName" required>
                                                <option value="" selected disabled>Select a Store</option>
                                                @foreach ($stores as $store)
                                                    <option value="{{ $store->id }}"
                                                        data-name="{{ $store->store_name }}">
                                                        {{ $store->store_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Part No.</label>
                                        <div class="mb-2 d-flex justify-content-end">
                                            <button type="button" id="selectAll"
                                                class="btn btn-sm btn-secondary">Select All</button>
                                        </div>
                                        <div id="partList" class="p-2 border rounded"
                                            style="max-height: 200px; overflow-y: auto;">
                                            <ul id="partNoList" class="list-group list-group-flush">
                                                <li class="list-group-item text-muted">Select a store to see parts</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="mt-4 d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-plus-circle-dotted me-2"></i>Generate & Add
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- QR Code Section -->
                            <div class="col-lg-7">
                                <!-- ปุ่มดาวน์โหลด PDF -->
                                <div class="mt-4 text-center">
                                    <button id="downloadPdf" class="btn btn-success">
                                        <i class="bi bi-file-earmark-pdf me-2"></i>Download as PDF
                                    </button>
                                </div>
                                <div class="border-start ps-lg-4">
                                    <div id="printArea" style="padding-top: 8mm;">
                                        <div style="width: 5.65in; margin: 0 auto;">
                                            <!-- Header -->
                                            <div class="d-flex align-items-center justify-content-between"
                                                style="margin-bottom: 1rem;">
                                                <img src="/assets/bvs-logo.png" alt="BVS Logo" style="height: 60px;" />
                                                <h3 class="mb-0 fw-bold">
                                                    QR Code <span id="storeTitle"></span>
                                                </h3>
                                                <div style="width: 60px;"></div> <!-- Spacer -->
                                            </div>

                                            <!-- พื้นที่ QR Code -->
                                            <div id="qrCodeContainer" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>



<script>
    const storeNameInput = document.getElementById("storeName");
    const partNoList = document.getElementById("partNoList");
    const selectAllButton = document.getElementById("selectAll");
    const qrCodeContainer = document.getElementById("qrCodeContainer");
    const downloadPdfButton = document.getElementById("downloadPdf");
    const printArea = document.getElementById('printArea');

    let storeName = "";
    let partsData = [];

    storeNameInput.addEventListener('change', async (event) => {
        const storeId = event.target.value;
        storeName = event.target.selectedOptions[0].getAttribute("data-name");

        if (storeId) {
            document.getElementById("storeTitle").textContent = storeName;
            const parts = await fetchParts(storeId);
            partsData = parts;
            displayPartsList(parts);
        } else {
            partNoList.innerHTML = '';
            document.getElementById("storeTitle").textContent = "";
        }
    });

    async function fetchParts(storeId) {
        const response = await fetch(`/parts/${storeId}`);
        return await response.json();
    }

    function displayPartsList(parts) {
        partNoList.innerHTML = '';
        if (parts.length === 0) {
            partNoList.innerHTML = '<li class="list-group-item text-muted">Select a store to see parts</li>';
        } else {
            parts.forEach(part => {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.value = part.id;
                checkbox.classList.add('part-checkbox', 'me-2');
                const label = document.createElement('span');
                label.textContent = part.part_no;
                listItem.appendChild(checkbox);
                listItem.appendChild(label);
                partNoList.appendChild(listItem);
            });
        }
    }

    selectAllButton.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.part-checkbox');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });
    });

    function getSelectedParts() {
        const selectedParts = [];
        const checkboxes = document.querySelectorAll('.part-checkbox:checked');
        checkboxes.forEach(checkbox => {
            selectedParts.push(checkbox.value);
        });
        return selectedParts;
    }

    async function generateQrItems(partIds) {
        const qrCodePromises = partIds.map(partId => {
            return new Promise((resolve, reject) => {
                const part = partsData.find(p => p.id == partId);
                if (part) {
                    // เพิ่ม pac_qty เข้าไปในข้อความ QR
                    const qrText = `${storeName}@${part.part_no}`;
                    //const qrText = `${storeName}@${part.part_no}@${part.pac_qty}`;

                    QRCode.toDataURL(qrText, {
                        margin: 1.5
                    }, function(err, url) {
                        if (err) return reject(err);

                        const qrItem = document.createElement("div");
                        qrItem.classList.add("qr-item");

                        const qrBorder = document.createElement("div");
                        qrBorder.classList.add("qr-border");

                        const qrImg = document.createElement("img");
                        qrImg.src = url;
                        qrImg.alt = qrText; // เพื่อให้ alt ตรงกับเนื้อหา
                        qrBorder.appendChild(qrImg);

                        const storeText = document.createElement("p");
                        storeText.classList.add("store-name");
                        storeText.textContent = storeName;

                        const partText = document.createElement("p");
                        partText.classList.add("part-no");
                        partText.textContent = part.part_no;

                        qrItem.appendChild(qrBorder);
                        qrItem.appendChild(storeText);
                        qrItem.appendChild(partText);
                        resolve(qrItem);
                    });
                } else {
                    resolve(null);
                }
            });
        });
        return Promise.all(qrCodePromises);
    }

    document.getElementById("qrForm").addEventListener("submit", async function(e) {
        e.preventDefault();
        const selectedParts = getSelectedParts();

        // Clear previous dynamic content
        document.querySelectorAll('.dynamic-page').forEach(page => page.remove());
        qrCodeContainer.innerHTML = '';

        if (selectedParts.length === 0) {
            return;
        }

        const itemsPerPage = 6;
        const firstPageParts = selectedParts.slice(0, itemsPerPage);
        const remainingParts = selectedParts.slice(itemsPerPage);

        // Generate QRs for the first page
        const firstPageQrItems = await generateQrItems(firstPageParts);
        firstPageQrItems.forEach(item => {
            if (item) qrCodeContainer.appendChild(item);
        });

        // Generate subsequent pages
        for (let i = 0; i < remainingParts.length; i += itemsPerPage) {
            const chunk = remainingParts.slice(i, i + itemsPerPage);

            const pageDiv = document.createElement('div');
            pageDiv.className = 'dynamic-page'; // Class for easy removal
            pageDiv.style.pageBreakBefore = 'always';

            const wrapperDiv = document.createElement('div');
            wrapperDiv.style.width = '5.65in';
            wrapperDiv.style.margin = '0 auto';
            wrapperDiv.style.paddingTop = '8mm';

            const headerDiv = document.createElement('div');
            headerDiv.className = 'd-flex align-items-center justify-content-between';
            headerDiv.style.marginBottom = '1rem';
            headerDiv.innerHTML = `
                <img src="/assets/bvs-logo.png" alt="BVS Logo" style="height: 60px;" />
                <h3 class="mb-0 fw-bold">QR Code <span>${storeName}</span></h3>
                <div style="width: 60px;"></div>
            `;

            const pageQrContainer = document.createElement('div');
            pageQrContainer.className = 'mt-3';
            pageQrContainer.style.display = 'grid';
            pageQrContainer.style.gridTemplateColumns = 'repeat(2, 2.75in)';
            pageQrContainer.style.gap = '0.2in';
            pageQrContainer.style.justifyContent = 'start';
            pageQrContainer.style.boxSizing = 'border-box';

            const pageQrItems = await generateQrItems(chunk);
            pageQrItems.forEach(item => {
                if (item) pageQrContainer.appendChild(item);
            });

            wrapperDiv.appendChild(headerDiv);
            wrapperDiv.appendChild(pageQrContainer);
            pageDiv.appendChild(wrapperDiv);
            printArea.appendChild(pageDiv);
        }
    });

    // Download PDF
    document.getElementById('downloadPdf').addEventListener('click', () => {
        const opt = {
            margin: 0,
            filename: 'QR-Code.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 3,
                scrollY: 0
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(printArea).save();
    });
</script>

</html>
