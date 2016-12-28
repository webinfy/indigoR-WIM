<?php if ($suggestions->count() > 0) { ?>
    <?php foreach ($suggestions as $suggestion) { ?>
        <div class="search-row">
            <a href="javascript:;" onclick="$('#searchbox-input').val($(this).text().trim()), $('#search-suggestion-box').hide();">
                <?= $suggestion->name ?>
            </a>
        </div>
    <?php } ?>
<?php } ?>
