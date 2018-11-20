<!-- track -->
<?php if ( !Yii::$app->user->getIsGuest() ): ?>
    <div style="display: none" class="track-analytics-data" user_id="<?=Yii::$app->user->identity->id?>"></div>
    <script>
        var remoteStatUrl = '<?=Yii::$app->params['remoteStatUrl']?>';
    </script>
<? endif; ?>
<!-- end track -->