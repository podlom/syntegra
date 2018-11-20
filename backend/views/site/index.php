<?php

/* @var $this yii\web\View */

$this->title = $companyName . ' CMS Admin Application';

?>
<div class="site-index">
    <div class="jumbotron-admin">
        <h1><?= $companyName ?> CMS Admin Application</h1>
    </div>

    <div class="body-content">
        <div class="row">
<?php

    if ($this->params['isEditor'] || $this->params['isAdmin']) {

?>
            <div class="col-lg-4">
                <h2>Manage Content</h2>

                <!--h3>Catalog</h3>
                <p class="text-center">
                <ul>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-category/index">Categories</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-subcategory1/index">Subcategories #1</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-subcategory2/index">Subcategories #2</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-subcategory3/index">Subcategories #3</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-subcategory4/index">Subcategories #4</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-item/index">Products</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-item-variant/index">Product Variants</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/catalog-item-image/index">Product Images</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/video-consultant/index">Video Consultant</a></li>
                    <li><a class="btn btn-default btn-gradient btn-alt btn-block" href="/block/index">Blocks</a></li>
                </ul>
                </p-->

                <h3>Content</h3>
                <p class="text-center">
                <ul>
                    <li><a class="btn btn-dark btn-gradient btn-alt btn-block" href="/page-category/index">Page Category</a></li>
                    <li><a class="btn btn-dark btn-gradient btn-alt btn-block" href="/page/index">Pages</a></li>
                    <li><a class="btn btn-success btn-gradient btn-alt btn-block" href="/news/index">News</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/slide/index">Slide</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/group-questions/index">Group Questions</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/questions/index">Questions</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/technologies/index">Technologies</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/partner-technology/index">Partner - Technology</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/team/index">Our Team</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/vacancies/index">Vacancies</a></li>
                     <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/reviews/index">Reviews</a></li>

                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/partner/index">Partners</a></li>
                    <li><a class="btn btn-primary btn-gradient btn-alt btn-block" href="/partner-category/index">Partner Categories</a></li>
                </ul>
                </p>
            </div>
<?php

    }

    if ($this->params['isAdmin']) {

?>
            <div class="col-lg-4">
                <h2>Manage SEO Parameters</h2>
                <p class="text-center">
                <ul>
                    <li><a class="btn btn-info btn-gradient btn-alt btn-block" href="/meta/index">SEO Meta</a></li>
                    <li><a class="btn btn-info btn-gradient btn-alt btn-block" href="/seometrics/index">SEO Metrics</a></li>
                </ul>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Manage Settings</h2>
                <p class="text-center">
                <ul>
                    <li><a class="btn btn-warning btn-gradient btn-alt btn-block" href="/menu/index">Menu</a></li>
                    <li><a class="btn btn-warning btn-gradient btn-alt btn-block" href="/languages/index">Languages</a></li>
                    <li><a class="btn btn-system btn-gradient btn-alt btn-block" href="/settings/default/index">Settings</a></li>
                    <li><a class="btn btn-system btn-gradient btn-alt btn-block" href="/error-log/index">Error log</a></li>
                    <li><a class="btn btn-system btn-gradient btn-alt btn-block" href="/contact/index">Contacts</a></li>
                </ul>
                </p>
            </div>
<?php

    }

?>

        </div>
    </div>
</div>
