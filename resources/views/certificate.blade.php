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
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 15px 20px;
            border-bottom: 2px solid #999;
            background: white;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 0 0 auto;
        }

        .header-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0066CC, #0052A3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            flex-shrink: 0;
        }

        .header-contact {
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 10px;
        }

        .header-contact-name {
            font-weight: bold;
            color: #0066CC;
        }

        .header-contact-phone {
            color: #0066CC;
        }

        .header-center {
            flex: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .header-company-name {
            font-size: 28px;
            font-weight: bold;
            color: #0066CC;
            letter-spacing: 2px;
        }

        .header-logo-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid #FF6600;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-logo-circle img {
            width: 45px;
            height: 45px;
        }

        .header-right {
            flex: 0 0 auto;
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 3px;
            font-size: 10px;
        }

        .header-office {
            font-weight: bold;
            color: #0066CC;
        }

        .header-office-phone {
            color: #0066CC;
        }

        .header-certificate-no {
            font-weight: bold;
            color: #CC0000;
            font-size: 10px;
            margin-top: 5px;
        }

        .fire-icon {
            width: 30px;
            height: 30px;
            background: #CC0000;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* Title Bar */
        .title-bar {
            background: linear-gradient(to right, #FF6600, #FF8800);
            color: white;
            text-align: center;
            padding: 10px 15px;
            border-bottom: 2px solid #999;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        /* Address Bar */
        .address-bar {
            background: #E60099;
            color: white;
            padding: 10px 15px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            border-bottom: 2px solid #999;
        }

        /* Content Section */
        .content {
            padding: 20px;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .content-row {
            display: flex;
            margin-bottom: 12px;
            align-items: center;
            gap: 10px;
        }

        .content-label {
            font-size: 11px;
            color: #CC0000;
            font-weight: bold;
            min-width: 130px;
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

        .content-value-fixed {
            font-size: 11px;
            color: #333;
            flex: 1;
        }

        /* Completion Message */
        .completion-message {
            text-align: center;
            margin: 15px 0;
            font-size: 10px;
            color: #333;
            line-height: 1.6;
            font-weight: bold;
        }

        /* ISO Badge */
        .iso-badge {
            text-align: center;
            margin: 10px 0;
        }

        .iso-badge-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFD700, #FFC700);
            border: 3px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .iso-badge-text {
            font-size: 10px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

        /* Signature Section */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #999;
            gap: 10px;
        }

        .signature-block {
            flex: 1;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            height: 1px;
            margin: 40px auto 5px;
            width: 100px;
        }

        .signature-label {
            font-size: 9px;
            color: #CC0000;
            font-weight: bold;
        }

        .signature-company-name {
            font-size: 10px;
            color: #333;
            font-weight: bold;
            padding: 5px;
        }

        /* Footer Bar */
        .footer-bar {
            background: #FFFF00;
            color: #333;
            text-align: center;
            padding: 8px 15px;
            font-size: 11px;
            font-weight: bold;
            border-top: 2px solid #999;
            border-bottom: 2px solid #999;
            line-height: 1.4;
        }

        /* Footer Icons */
        .footer-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 12px 15px;
            background: white;
            border-bottom: 2px solid #D4A574;
        }

        .footer-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Utility Classes */
        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .ok-mark {
            color: #00AA00;
            font-weight: bold;
        }

        /* Two Column Layout for Signatures */
        .two-column {
            display: flex;
            gap: 10px;
        }

        .two-column > div {
            flex: 1;
        }

        .skfire{
            font-size: 2px;
            
        }

        /* Print Styles */
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
            }
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .certificate-container {
                width: 100%;
                height: auto;
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                {{-- <div class="header-logo">SK</div> --}}
                <div class="header-contact">
                    <div class="header-contact-name">Chetan Gadhavi</div>
                    <div class="header-contact-phone">6352796979</div>
                    <div class="header-contact-phone">6359988211</div>
                </div>
            </div>

            <div class="header-center">
                <img src="{{ asset('images/safety first.jpg') }}" 
                    alt="Safety First Logo" style="width:120px; height:auto;">
            </div>

            <div class="header-right">
                <div class="header-office">Porbandar Office</div>
                <div class="header-office-phone">6359988217</div>
                <div class="header-office-phone">6359988216</div>
                <div class="header-certificate-no">CERTIFICATE NO. SSFS/2025-26/NEW-339</div>
            </div>
        </div>
        <div>
            <div class="header-left">
                <img src="{{ asset('images/sk logo.jpeg') }}" 
                    alt="Safety First Logo" style="width:120px; height:auto;">
                
            </div>

            <div class="header-center">
               <div class="skfire">SHREE S.K.FIRE</div> 
            </div>

            <div class="header-right">
                <div class="header-office">Porbandar Office</div>
                <div class="header-office-phone">6359988217</div>
                <div class="header-office-phone">6359988216</div>
                <div class="header-certificate-no">CERTIFICATE NO. SSFS/2025-26/NEW-339</div>
            </div>
        </div>

        <!-- Title Bar -->
        <div class="title-bar">
            REFILLING CERTIFICATE
        </div>

        <!-- Address Bar -->
        <div class="address-bar">
            Office No.2, Near Raja Oil Mil, Vadi Plot, (PORBANDAR) City - 360575, Gujarat.
        </div>

        <!-- Content -->
        <div class="content">
            <div>
                <div class="content-row">
                    <span class="content-label">Certified M/s. :</span>
                    <span class="content-value">SHREE VARJANG JALIYA KUMAR SHALA UPLETA</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Type of FireExtinguisher :</span>
                    <span class="content-value">REFILLING OF TYPE FIRE EXTINGUISHERS 10 KGS 2 PCS</span>
                </div>

                <div class="content-row">
                    <span class="content-label"></span>
                    <span class="content-value"></span>
                </div>

                <div class="content-row">
                    <span class="content-label"></span>
                    <span class="content-value"></span>
                </div>

                <div class="content-row">
                    <span class="content-label">No. of Pcs. :</span>
                    <span class="content-value">2 Pcs.</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Refilling Date :</span>
                    <span class="content-value">09-03-2026</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Next Due Date :</span>
                    <span class="content-value">08-03-2027</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Sr. No. :</span>
                    <span class="content-value">SKFS/REF/2910-11/2025-26</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Parts :</span>
                    <span class="content-value">OK</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Certificate Valid Date :</span>
                    <span class="content-value">08-03-2027</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Hy. Test :</span>
                    <span class="content-value">----</span>
                </div>

                <div class="content-row">
                    <span class="content-label">Remarks :</span>
                    <span class="content-value">----</span>
                </div>

                <!-- Completion Message -->
                <div class="completion-message">
                    The above carried out work is done to my satisfaction : The work is completed<br/>
                    Thanking your & assuring you of our best & prompt service at all time.<br/>
                    We remain, Your faithfully.
                </div>

                <!-- ISO Badge -->
                <div class="iso-badge">
                    <div class="iso-badge-circle">✓</div>
                    <div class="iso-badge-text">ISO 9001<br/>CERTIFIED</div>
                </div>
            </div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Signature of the technician</div>
                </div>

                <div style="flex: 0.5; padding-top: 20px;">
                    <div class="signature-company-name">For, S.K.FIRE & SAFETY</div>
                </div>

                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Authority Signature</div>
                </div>
            </div>
        </div>

        <!-- Footer Bar -->
        <div class="footer-bar">
            ISI AND TAC APPROVED MATERIALS : SERVICES<br/>
            AVAILABLE IN ALL CENTERS OF GUJARAT
        </div>

        <!-- Footer Icons -->
        <div class="footer-icons">
            <div class="footer-icon">🔴</div>
            <div class="footer-icon">⭕</div>
            <div class="footer-icon">📋</div>
            <div class="footer-icon">⚙️</div>
            <div class="footer-icon">🛡️</div>
            <div class="footer-icon">🔥</div>
            <div class="footer-icon">📌</div>
        </div>
    </div>
</body>
</html>