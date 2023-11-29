<!DOCTYPE html>
<html>
<head>
    <title>หน้าพิมพ์</title>
    <style>
@media print {
    body {
        transform: rotate(90deg);
        transform-origin: left top;
        width: 100vh;
        height: 100vw;
        position: fixed;
        top: 0;
        left: 0;
    }

    @page {
        size: landscape;
    }
}

    </style>
</head>
<body>
    <!-- เนื้อหาที่คุณต้องการพิมพ์ -->
    <h1>นี่คือหน้าพิมพ์</h1>
    <p>นี่คือเนื้อหาที่คุณต้องการพิมพ์.</p>
    

</body>    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>
</html>
