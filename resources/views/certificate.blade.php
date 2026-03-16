<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fire Extinguisher Certificate</title>
    <style>
        /* ============ RESET ============ */
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

        /*
            NO @import from Google Fonts — server has no internet.
            Use only system fonts available on Linux (DejaVu, Liberation, etc.)
        */
        body {
            font-family: "DejaVu Sans", "Liberation Sans", Arial, Helvetica, sans-serif;
            background: white;
            color: #333;
            font-size: 14px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* ============ CERTIFICATE CONTAINER ============ */
        .certificate-container {
            width: 200mm;
            margin: 0 auto;
            background: white;
            border: 3px solid #D4A574;
            padding: 0;
        }

        /* ============ HEADER 1: Contact | Logo | Office ============ */
        /*
            WeasyPrint older versions have partial flexbox support.
            Use table-based layout as fallback for reliability.
        */
        .header {
            display: table;
            width: 100%;
            padding: 6px 15px;
            background: white;
        }

        .header-left,
        .header-center,
        .header-right {
            display: table-cell;
            vertical-align: middle;
        }

        .header-left {
            width: 30%;
            font-size: 12px;
        }

        .header-center {
            width: 40%;
            text-align: center;
        }

        .header-right {
            width: 30%;
            text-align: right;
            font-size: 12px;
        }

        .header-left-name,
        .header-right-office {
            font-weight: bold;
            color: #2792fd;
        }

        .header-left-phone,
        .header-right-phone {
            color: #2792fd;
            font-size: 11px;
        }

        .header-logo-circle img {
            width: 90px;
            height: auto;
        }

        /* ============ HEADER 2: SK Logo | Title | Fire Icon ============ */
        .header-logo-section {
            display: table;
            width: 100%;
            padding: 4px 15px;
            border-bottom: 2px solid #999;
            border-top: 1px solid #eee;
            background: white;
        }

        .header-logo-section-left,
        .header-logo-section-center,
        .header-logo-section-right {
            display: table-cell;
            vertical-align: middle;
        }

        .header-logo-section-left,
        .header-logo-section-right {
            width: 110px;
            text-align: center;
        }

        .header-logo-section-center {
            text-align: center;
        }

        .sk-logo img,
        .fire-icon-box img {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .header-title {
            font-size: 44px;
            font-weight: bold;
            color: #2792fd;
            letter-spacing: 3px;
            line-height: 1.1;
            font-family: "DejaVu Sans", "Liberation Sans", Arial, sans-serif;
        }

        /* ============ TITLE BAR ============ */
        .title-bar {
            text-align: center;
            padding: 10px 15px;
            color: #fff;
            border-bottom: 2px solid #999;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 3px;
            background: #FF8800;
            font-family: "DejaVu Serif", Georgia, serif;
        }

        /* ============ ADDRESS BAR ============ */
        .address-bar {
            background: #E60099;
            color: white;
            padding: 8px 15px;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            border-bottom: 2px solid #999;
            line-height: 1.4;
        }

        /* ============ CONTENT SECTION ============ */
        .content {
            padding: 10px 18px;
        }

        /* Table layout for content rows */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .content-table tr td {
            padding: 7px 8px;
            vertical-align: middle;
        }

        /* Alternating row background for readability */
        .content-table tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .content-table tr:nth-child(even) {
            background-color: #ffffff;
        }

        .content-label {
            font-size: 16px;
            color: #CC0000;
            font-weight: bold;
            white-space: nowrap;
            width: 210px;
            /* border-right: 2px solid #e0e0e0; */
            text-align: right;
            padding-right: 14px;
        }

        .content-value {
            font-size: 16px;
            color: #2792fd;
            font-weight: bold;
            padding-left: 16px;
            text-align: center;
            word-break: break-word;
            letter-spacing: 0.5px;
        }

        /* ============ COMPLETION MESSAGE ============ */
        .completion-message {
            text-align: center;
            margin: 12px 0 6px;
            font-size: 14px;
            color: #CC0000;
            line-height: 1.6;
            font-weight: bold;
        }

        /* Table layout for faithfully + company name row */
        .faithfully-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }

        .faithfully-left,
        .faithfully-right {
            display: table-cell;
            color: #CC0000;
            font-size: 14px;
            font-weight: bold;
            vertical-align: middle;
        }

        .faithfully-right {
            text-align: right;
        }

        /* ============ ISO BADGE ============ */
        .iso-badge {
            text-align: center;
            margin: 4px 0;
        }

        .iso-badge img {
            height: 100px;
            width: 130px;
        }

        /* ============ SIGNATURE SECTION ============ */
        .signature-section {
            display: table;
            width: 100%;
            margin: 10px 0 4px;
        }

        .signature-block {
            display: table-cell;
            text-align: center;
            vertical-align: bottom;
            width: 50%;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 140px;
            margin: 5px auto 4px;
        }

        .signature-label {
            font-size: 13px;
            color: #CC0000;
            font-weight: bold;
            line-height: 1.3;
        }

        /* ============ FOOTER BAR ============ */
        .footer-bar {
            background: #FFFF00;
            color: #333;
            text-align: center;
            padding: 7px 15px;
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #999;
            border-bottom: 2px solid #999;
            line-height: 1.4;
        }

        /* ============ FOOTER ICONS ============ */
        /* Table layout for footer icons */
        .footer-icons-table {
            display: table;
            width: 100%;
            padding: 8px 10px;
        }

        .footer-icons-table td {
            text-align: center;
            vertical-align: middle;
            padding: 2px 4px;
        }

        .footer-icons-table img {
            width: 45px;
            height: 40px;
            object-fit: contain;
        }

        /* ============ PRINT STYLES ============ */
        @page {
            size: A4;
            margin: 5mm;
        }

        @media print {
            body { margin: 0; padding: 0; }
            .certificate-container {
                border: 3px solid #D4A574;
                width: 100%;
            }
        }

        @media (max-width: 1024px) {
            .certificate-container {
                width: 100%;
            }
            .header-title { font-size: 32px; }
            .title-bar { font-size: 18px; }
        }
    </style>
</head>

<body>
<div class="certificate-container">

    <!-- ============ HEADER 1: Contact | Logo | Office ============ -->
    <div class="header">
        <div class="header-left">
            <div class="header-left-name">Chetan Gadhavi</div>
            <div class="header-left-phone">6352796979</div>
            <div class="header-left-phone">6359988211</div>
        </div>
        <div class="header-center">
            <div class="header-logo-circle">
                <img src="images/safety_first.jpg">
            </div>
        </div>
        <div class="header-right">
            <div class="header-right-office">Porbandar Office</div>
            <div class="header-right-phone">6359988217</div>
            <div class="header-right-phone">6359988216</div>
        </div>
    </div>

    <!-- ============ HEADER 2: SK Logo | Title | Fire Icon ============ -->
    <div class="header-logo-section">
        <div class="header-logo-section-left">
            <div class="sk-logo">
                <img src="images/sk_logo.jpeg">
            </div>
        </div>
        <div class="header-logo-section-center">
            <div class="header-title">SHREE S.K.FIRE</div>
        </div>
        <div class="header-logo-section-right">
            <div class="fire-icon-box">
                <img src="images/fire_extinguare.png">
            </div>
        </div>
    </div>

    <!-- ============ TITLE BAR ============ -->
    <div class="title-bar">
        REFILLING CERTIFICATE
    </div>

    <!-- ============ ADDRESS BAR ============ -->
    <div class="address-bar">
        Office No.2, Near Raja Oil Mil, Vadi Plot, (PORBANDAR) City - 360575, Gujarat.
    </div>

    <!-- ============ CONTENT ============ -->
    <div class="content">

        <!-- All rows as a reliable table -->
        <table class="content-table">
            <tr>
                <td class="content-label">CERTIFICATE NO. :</td>
                <td class="content-value">{{ $certificate_number }}</td>
            </tr>
            <tr>
                <td class="content-label">Certified M/s. :</td>
                <td class="content-value">{{ $issued_to }}</td>
            </tr>
            <tr>
                <td class="content-label">Type of FireExtinguisher :</td>
                <td class="content-value">{{ $fire_extinguisher_type }}</td>
            </tr>
            <tr>
                <td class="content-label">No. of Pcs. :</td>
                <td class="content-value">{{ $no_of_pc }} Pcs.</td>
            </tr>
            <tr>
                <td class="content-label">Refilling Date :</td>
                <td class="content-value">{{ $issue_date }}</td>
            </tr>
            <tr>
                <td class="content-label">Next Due Date :</td>
                <td class="content-value">{{ $dueDate }}</td>
            </tr>
            <tr>
                <td class="content-label">Sr. No. :</td>
                <td class="content-value">{{ $serial_no }}</td>
            </tr>
            <tr>
                <td class="content-label">Parts :</td>
                <td class="content-value">OK</td>
            </tr>
            <tr>
                <td class="content-label">Certificate Valid Date :</td>
                <td class="content-value">{{ $dueDate }}</td>
            </tr>
            <tr>
                <td class="content-label">Hy. Test :</td>
                <td class="content-value">{{ $hy_test ?? '----' }}</td>
            </tr>
            <tr>
                <td class="content-label">Remarks :</td>
                <td class="content-value">{{ $notes ?? '----' }}</td>
            </tr>
        </table>

        <!-- Completion Message -->
        <div class="completion-message">
            The above carried out work is done to my satisfaction : The work is completed<br>
            Thanking your &amp; assuring you of our best &amp; prompt service at all time.
        </div>

        <!-- Faithfully Row -->
        <div class="faithfully-row">
            <div class="faithfully-left">We remain, Your faithfully.</div>
            <div class="faithfully-right">For, S.K.FIRE &amp; SAFETY</div>
        </div>

        <!-- ISO Badge -->
        <div class="iso-badge">
            <img src="images/iso_9001.jpg">
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Signature of the technician</div>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Authority Signature</div>
            </div>
        </div>

    </div><!-- end .content -->

    <!-- ============ FOOTER BAR ============ -->
    <div class="footer-bar">
        ISI AND TAC APPROVED MATERIALS : SERVICES<br>
        AVAILABLE IN ALL CENTERS OF GUJARAT
    </div>

    <!-- ============ FOOTER ICONS ============ -->
    <table class="footer-icons-table">
        <tr>
            <td><img src="images/fire_extinguare.png"></td>
            <td><img src="images/footer_image_1.jpg"></td>
            <td><img src="images/footer_image_2.jpg"></td>
            <td><img src="images/footer_image_3.jpg"></td>
            <td><img src="images/footer_image_4.jpg"></td>
            <td><img src="images/footer_image_5.jpg"></td>
            <td><img src="images/footer_image_6.jpg"></td>
            <td><img src="images/footer_image_7.jpg"></td>
            <td><img src="images/footer_image_8.jpg"></td>
            <td><img src="images/footer_image_9.jpg"></td>
        </tr>
    </table>

</div><!-- end .certificate-container -->
</body>
</html>
