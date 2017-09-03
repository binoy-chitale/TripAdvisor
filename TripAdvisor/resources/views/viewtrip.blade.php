<html>
<body>
<script>
var name = localStorage['name'];
content = localStorage[name];
 console.log(content);
 document.open();
 document.write(content);
 document.close();
</script>
</body>
</html>