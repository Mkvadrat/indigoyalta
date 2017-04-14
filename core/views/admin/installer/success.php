<div class="block small center login">

        <div class="block_head">
          <h2>Установка FastCMS</h2>
        </div>

    <div class="block_content">

        <?php if (isset($message)) { ?><div class="message success"><p>FastCMS успешно установлена</p></div><?php } ?>

        <form action="<?php echo admin_url('auth'); ?>" method="POST">
        
            <?php if (isset($username)) { ?>
            <div class="fieldset clearfix">
              <label class="full">Логин: <strong><?php echo $username; ?></strong></label>
            </div>
            <div class="fieldset clearfix">
              <label class="full">Пароль: <strong><?php echo $password; ?></strong></label>
            </div>
            <?php } ?>
        
            <div class="fieldset noborder clearfix">
                <label class="full">
                    <input type="submit" class="submit" value="Войти" />
                </label>
            </div>
        </form>
    </div>
</div>