<script src="/js/jquery.min.js"></script>
<script>//根据ip获取城市
$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function() {
    document.getElementById('L_city').innerHTML = remote_ip_info.city;
});
</script>