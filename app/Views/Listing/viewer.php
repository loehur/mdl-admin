<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script>
    $(document).ready(function() {
        content();
    });

    function content() {
        var p1 = "<?= $data['p1'] ?>";
        $("div#content").load('<?= $this->BASE_URL ?><?= $data['page'] ?>/content/' + p1);
    }
</script>