<?php
$title = Yii::t('app', 'Home');
$title1 =  Yii::t('app', 'Blog');
$this->title = $title1;
?>
        <section class="underhead" id="particles-blog">
            <div class="wrap wrap_size_large">
              <div class="breadcrumbs">
                <ul>
                  <li><a href="/"><?=$title?></a></li>
                  <li><span><?=$title1?></span></li>
                </ul>
              </div>
              <h3 class="underhead__title wow fadeInLeft"><?=$title1?></h3>
            </div>
        </section>
        <div class="blog-content">
            <?php echo $this->render('news1',['news'=>$news]);?>
        </div>
      <div class="blog-more-wr"><a class="btn" href="#" id="more_news">More</a></div>

      <section class="tr-u-bis wow fadeInUp">
        <div class="wrap wrap_size_large">
          <div class="tr-u-bis__wr">
            <div class="tr-u-bis__inner">
              <div class="tr-u-bis__title-wr">
                <h3 class="tr-u-bis__title">Transform your Business with Us</h3>
              </div>
              <div class="tr-u-bis__txt-n-button">
                <div class="tr-u-bis__txt">From the speed and effectiveness of the work of employees depends ovn the development of business. Creation of personal knowledge base, storage of documents and ensuring their safety</div>
                <div class="tr-u-bis__button"><a class="btn" href="#"><?=Yii::t('app','Full Article')?></a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section section_slider wow fadeInUp">
        <div class="slider__wr">
          <?php echo $this->render('/site/slider');?>
        </div>
      </section>
      <section class="section section_partners wow fadeInUp">
        <div class="section_content__wrapp">
          <div class="partners_wrapp__logo">
            <div class="partners__logo"><img src="../images/micros.jpg"></div>
            <div class="partners__logo"><img src="../images/hp.png"></div>
            <div class="partners__logo"><img src="../images/lenovo.png"></div>
            <div class="partners__logo"><img src="../images/dell.png"></div>
            <div class="partners__logo"><img src="../images/cisco.png"></div>
            <div class="partners__logo"><img src="../images/xerox.png"></div>
          </div>
          <h2 class="section_partners__title">OUR PARTNERS</h2>
        </div>
      </section>
<?php
echo $this->render('/site/footer');
?>
<script>

            var token = $('meta[name=csrf-token]').attr("content");
            var page = 0;
            var limit = 4;
            var offset = 0;

            function newPage() {
                page ++;
            }

            function newOffset() {
                if (page > 0) {
                    offset += (page * limit) ;
                } else {
                    offset = 0;
                }
            }

            function loadMoreNews() {
                newPage();
                newOffset();

                $.ajax({
                    type: 'POST',
                    url: '/news/index',
                    data: {'limit': limit, 'offset': offset, '<?= Yii::$app->request->csrfParam ?>' : '<?= Yii::$app->request->getCsrfToken()?>' },
                    success: function (data) {
                        // alert(data);
                        if (data) {
                            $('.blog-content').append(data);
                        }
                        return true;
                    }
                });
            }

            $('#more_news').click(function (ev1) {
                var th1 = $(this);
                ev1.preventDefault();
                loadMoreNews();
            });

</script>
