<?php
// Script to dynamically read and format all source code files for the project report
$directories = [
    '.', // Root (HTML files & schema)
    './css', // CSS
    './js', // JS
    './api' // PHP backend
];

$allowedExtensions = ['html', 'css', 'js', 'php', 'sql'];
$excludeFiles = ['view_all_code.php']; // Exclude this script itself

$filesToDisplay = [];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $allowedExtensions) && !in_array($file, $excludeFiles)) {
                $filesToDisplay[] = $dir . '/' . $file;
            }
        }
    }
}

// Sort files to look organized in the report (HTML first, then CSS, JS, DB, APIs)
sort($filesToDisplay);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Project Source Code</title>
    <!-- Highlight.js for VS Light styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/vs.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/sql.min.js"></script>
    <script>hljs.highlightAll();</script>
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            padding: 40px;
            max-width: 900px;
            margin: auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 40px;
        }
        h1 { font-size: 24pt; margin: 0; }
        p.subtitle { color: #555; font-family: Arial, sans-serif; }
        
        .file-section {
            margin-bottom: 60px;
            page-break-inside: avoid;
        }
        .file-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 15px;
            background: #f0f0f0;
            padding: 10px;
            border-left: 5px solid #4f46e5;
            font-family: Arial, sans-serif;
        }
        pre {
            background-color: transparent;
            margin: 0;
            padding: 0;
            font-size: 10pt;
            font-family: Consolas, 'Courier New', monospace;
            border: 1px solid #eee;
            border-radius: 4px;
            overflow-x: auto;
        }
        code {
            padding: 15px !important;
            background-color: #fafafa !important;
        }
        
        @media print {
            body { padding: 0; background-color: #fff; }
            .file-title { background: #eee; border-left: 5px solid #333; }
            pre { border: none; }
            code { background-color: #fff !important; color: #000 !important; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>PROJECT SOURCE CODE APPENDIX</h1>
        <p class="subtitle">Complete Student Attendance Management System Codebase</p>
        <button class="no-print" onclick="window.print()" style="padding: 10px 20px; margin-top: 20px; font-size: 16px; cursor: pointer; border: none; border-radius: 5px; background: #4f46e5; color: white;">
            🖨️ Print Entire Appendix to PDF
        </button>
        <p class="no-print" style="margin-top:10px; font-size:12px; font-style:italic;">(Or you can select all text [Ctrl+A] and paste into MS Word)</p>
    </div>

    <?php foreach($filesToDisplay as $index => $filePath): ?>
        <?php 
            $content = file_get_contents($filePath);
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
            
            // Map extension to highlight.js class
            $langClass = 'language-' . ($ext === 'html' ? 'xml' : $ext);
        ?>
        <div class="file-section">
            <div class="file-title"><?php echo ($index + 1) . '. ' . htmlspecialchars(basename($filePath)); ?> <span style="font-weight:normal; font-size:10pt; color:#666;">(<?php echo htmlspecialchars($filePath); ?>)</span></div>
            <pre><code class="<?php echo $langClass; ?>"><?php echo htmlspecialchars($content); ?></code></pre>
        </div>
    <?php endforeach; ?>

</body>
</html>
