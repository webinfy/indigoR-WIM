<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error" id="flashError" onclick="this.classList.add('hidden');"><?= $message ?></div>

<script>
    setTimeout(function () {
        document.getElementById('flashError').style.display = 'none';
    }, 4000);
</script>

