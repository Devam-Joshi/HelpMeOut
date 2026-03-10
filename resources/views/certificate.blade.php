<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Extinguisher Certificate</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: white;
            color: #333;
        }

        .certificate-container {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background: white;
            border: 3px solid #D4A574;
            padding: 0;
            page-break-after: always;
            font-size: 24px;
        }

        /* ============ HEADER SECTION ============ */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1px 15px;
            /* border-bottom: 2px solid #999; */
            background: white;
            min-height: 80px;
            padding-bottom: 0%;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
            font-size: 12px;
        }

        .header-left-contact {
            display: flex;
            flex-direction: column;
            gap: 1px;
            font-size: 12px;
        }

        .header-left-name {
            font-weight: bold;
            color: #0066CC;
        }

        .header-left-phone {
            color: #0066CC;
        }

        /* ============ HEADER CENTER - LOGO CIRCLE ============ */
        .header-center {
            flex: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            position: relative;
            padding-top: -20px;
        }

        .header-logo-circle img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        /* ============ HEADER RIGHT ============ */
        .header-right {
            flex: 0 0 auto;
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 12px;
        }

        .header-right-office {
            font-weight: bold;
            color: #0066CC;
        }

        .header-right-phone {
            color: #0066CC;
        }

        .header-right-certificate-no {
            font-weight: bold;
            color: #CC0000;
            font-size: 9px;
            margin-top: 3px;
            line-height: 1.2;
        }

        /* ============ SK LOGO & TITLE SECTION ============ */
        .header-logo-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 20px;
            border-bottom: 2px solid #999;
            background: white;
            min-height: 100px;
        }

        .sk-logo {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sk-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .header-title-wrapper {
            flex: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .header-title {
            font-size: 48px;
            font-weight: bold;
            color: #0066CC;
            letter-spacing: 3px;
            line-height: 1;
        }

        .fire-icon-box {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fire-icon-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* ============ TITLE BAR ============ */
        .title-bar {
        text-align: center;
        padding: 12px 15px;
        border-bottom: 2px solid #999;
        font-size: 26px;
        font-weight: bold;
        letter-spacing: 2px;
        background: #FF8800;
    }

    .title-bar span {
        background: linear-gradient(transparent 60%, #FF8800 60%);
        padding: 3px 8px;
    }

        /* ============ ADDRESS BAR ============ */
        .address-bar {
            background: #E60099;
            color: white;
            padding: 10px 15px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            border-bottom: 2px solid #999;
            line-height: 1.4;
        }

        /* ============ CONTENT SECTION ============ */
        .content {
            padding: 18px;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .content-row {
            display: flex;
            margin-bottom: 10px;
            align-items: center;
            gap: 8px;
            text-align: center;
        }

        .content-label {
            font-size: 11px;
            color: #CC0000;
            font-weight: bold;
            min-width: 140px;
            flex-shrink: 0;
        }

        .content-value {
            font-size: 11px;
            color: #333;
            border-bottom: 1px dotted #999;
            flex: 1;
            padding-bottom: 2px;
            word-break: break-word;
        }

        .empty-row {
            min-height: 15px;
        }

        /* ============ COMPLETION MESSAGE ============ */
        .completion-message {
            text-align: center;
            margin: 12px 0;
            font-size: 10px;
            color: #CC0000;
            line-height: 1.5;
            font-weight: bold;
        }

        /* ============ ISO BADGE ============ */
        .iso-badge {
            text-align: center;
            margin: 8px 0;

        }

        .iso-badge img {
            text-align: center;
            margin: 8px 0;
            height: 120px;
            width: 150px;
        }

        .iso-badge-circle {
            width: 90px;
            height: 90px;
            margin: 0 auto;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFD700, #FFC700);
            border: 3px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            font-weight: bold;
            color: #333;
        }

        .iso-badge-text {
            font-size: 10px;
            font-weight: bold;
            color: #333;
            margin-top: 4px;
            line-height: 1.3;
        }

        /* ============ SIGNATURE SECTION ============ */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 12px;
            /* border-top: 1px solid #999; */
            gap: 8px;
            align-items: flex-start;
        }

        .signature-block {
            flex: 1;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            height: 1px;
            margin: 5px auto 5px;
            width: 110px;
        }

        .signature-label {
            font-size: 9px;
            color: #CC0000;
            font-weight: bold;
            line-height: 1.2;
        }

        .signature-center {
            flex: 0.6;
            text-align: center;
            padding-top: 5px;
        }

        .signature-center-text {
            font-size: 10px;
            color: #333;
            font-weight: bold;
        }

        /* ============ FOOTER BAR ============ */
        .footer-bar {
            background: #FFFF00;
            color: #333;
            text-align: center;
            padding: 8px 15px;
            font-size: 20px;
            font-weight: bold;
            border-top: 2px solid #999;
            border-bottom: 2px solid #999;
            line-height: 1.4;
        }

        /* ============ FOOTER ICONS ============ */
        .footer-icons{
            display:flex;
            justify-content:center;
            gap:10px;
            flex-wrap:wrap;
            margin-top:20px;
        }

        .footer-icon img{
            width:50px;
            height:auto;
        }

        .footer-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .content-data {
            font-size: 18px;
        }

        /* ============ PRINT STYLES ============ */
        @page {
            size: A4;
            margin: 0;
            padding: 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .certificate-container {
                border: 3px solid #D4A574;
                box-shadow: none;
                page-break-after: always;
                width: 210mm;
                height: 297mm;
            }
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1024px) {
            .certificate-container {
                width: 100%;
                height: auto;
                min-height: 100vh;
            }

            .header-title {
                font-size: 36px;
            }

            .title-bar {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        
        <!-- ============ HEADER SECTION 1: Contact Info & Logo Circle ============ -->
        <div class="header">
            <!-- Left: Contact Info -->
            <div class="header-left">
                <div class="header-left-contact">
                    <div class="header-left-name">Chetan Gadhavi</div>
                    <div class="header-left-phone">6352796979</div>
                    <div class="header-left-phone">6359988211</div>
                </div>
            </div>

            <!-- Center: Logo Circle -->
            <div class="header-center">
                <div class="header-logo-circle">
                    <img src="{{ asset('images/safety_first.jpg') }}" alt="Safety Logo">
                </div>
            </div>

            <!-- Right: Office Info -->
            <div class="header-right">
                <div class="header-right-office">Porbandar Office</div>
                <div class="header-right-phone">6359988217</div>
                <div class="header-right-phone">6359988216</div>
                {{-- <div class="header-right-certificate-no">
                    CERTIFICATE NO.
                    SSFS/2025-26/NEW-339
                </div> --}}
            </div>
        </div>

        <!-- ============ HEADER SECTION 2: SK Logo, Title, Fire Icon ============ -->
        <div class="header-logo-section">
            <!-- Left: SK Logo -->
            <div class="sk-logo">
                <img src="{{ asset('images/sk_logo.jpeg') }}" alt="SK Logo">
            </div>

            <!-- Center: Title -->
            <div class="header-title-wrapper">
                <div class="header-title">SHREE S.K.FIRE</div>
            </div>

            <!-- Right: Fire Extinguisher Icon -->
            <div class="fire-icon-box">
                <img src="{{ asset('images/fire_extinguare.png') }}" alt="Fire Extinguisher">
            </div>
        </div>

        <!-- ============ TITLE BAR ============ -->
        <div class="title-bar">
            REFILLING CERTIFICATE
        </div>

        <!-- ============ ADDRESS BAR ============ -->
        <div class="address-bar">
            Office No.2, Near Raja Oil Mil, Vadi Plot, (PORBANDAR) City - 360575 ,Gujarat.
        </div>

        <!-- ============ CONTENT ============ -->
        <div class="content">
            <div class="content-data">
                <!-- Row 1: Company -->
                <div class="content-row">
                    <span class="content-label">Certified M/s. :</span>
                    <span class="content-value">SHREE VARJANG JALIYA KUMAR SHALA UPLETA</span>
                </div>

                <!-- Row 2: Fire Extinguisher Type -->
                <div class="content-row">
                    <span class="content-label">Type of FireExtinguisher :</span>
                    <span class="content-value">REFILLING OF TYPE FIRE EXTINGUISHERS 10 KGS 2 PCS</span>
                </div>

                {{-- <!-- Empty Row 1 -->
                <div class="content-row empty-row"></div>

                <!-- Empty Row 2 -->
                <div class="content-row empty-row"></div> --}}

                <!-- Row 3: Pieces -->
                <div class="content-row">
                    <span class="content-label">No. of Pcs. :</span>
                    <span class="content-value">2 Pcs.</span>
                </div>

                <!-- Row 4: Refilling Date -->
                <div class="content-row">
                    <span class="content-label">Refilling Date :</span>
                    <span class="content-value">09-03-2026</span>
                </div>

                <!-- Row 5: Next Due Date -->
                <div class="content-row">
                    <span class="content-label">Next Due Date :</span>
                    <span class="content-value">08-03-2027</span>
                </div>

                <!-- Row 6: Sr. No -->
                <div class="content-row">
                    <span class="content-label">Sr. No. :</span>
                    <span class="content-value">SKFS/REF/2910-11/2025-26</span>
                </div>

                <!-- Row 7: Parts -->
                <div class="content-row">
                    <span class="content-label">Parts :</span>
                    <span class="content-value">OK</span>
                </div>

                <!-- Row 8: Certificate Valid Date -->
                <div class="content-row">
                    <span class="content-label">Certificate Valid Date :</span>
                    <span class="content-value">08-03-2027</span>
                </div>

                <!-- Row 9: Hy. Test -->
                <div class="content-row">
                    <span class="content-label">Hy. Test :</span>
                    <span class="content-value">----</span>
                </div>

                <!-- Row 10: Remarks -->
                <div class="content-row">
                    <span class="content-label">Remarks :</span>
                    <span class="content-value">----</span>
                </div>

                <!-- Completion Message -->
                <div class="completion-message">
                    The above carried out work is done to my satisfaction : The work is completed<br/>
                    Thanking your & assuring you of our best & prompt service at all time.
                </div>

<div style="display:flex; justify-content:space-between; color:#CC0000;">
    <div>We remain, Your faithfully.</div>
    <div>For, S.K.FIRE & SAFETY</div>
</div>

                <!-- ISO Badge -->
                <div class="iso-badge">
                    <img src="{{ asset('images/iso_9001.jpg') }}" alt="Fire Extinguisher">
                </div>
            </div>

            <!-- Signature Section -->
            <div class="signature-section">
                <!-- Left Signature -->
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Signature of the technician</div>
                </div>

                <!-- Center Company Name -->
                {{-- <div class="signature-center">
                    <div class="signature-center-text">For, S.K.FIRE & SAFETY</div>
                </div> --}}

                <!-- Right Signature -->
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Authority Signature</div>
                </div>
            </div>
        </div>

        <!-- ============ FOOTER BAR ============ -->
        <div class="footer-bar">
            ISI AND TAC APPROVED MATERIALS : SERVICES<br/>
            AVAILABLE IN ALL CENTERS OF GUJARAT
        </div>

        <!-- ============ FOOTER ICONS ============ -->
        <div class="footer-icons">
            <div class="footer-icon"><img src="{{ asset('images/fire_extinguare.png') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_1.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_2.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_3.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_4.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_5.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_6.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_7.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_8.jpg') }}" alt=""></div>
            <div class="footer-icon"><img src="{{ asset('images/footer_image_9.jpg') }}" alt=""></div>
        </div>

    </div>
</body>
</html>