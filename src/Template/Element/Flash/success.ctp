<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success" id="flashSuccess" onclick="this.classList.add('hidden')"><?= $message ?></div>

<script>
    setTimeout(function () {
        document.getElementById('flashSuccess').style.display = 'none';
    }, 4000);
</script>
