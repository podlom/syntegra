<?php
if ($page) {
    echo '<section class="underhead-consulting-item">
        <div class="wrap wrap_size_large">
          <div class="breadcrumbs">
            <ul>
              <li><a href="/">' . $title . '</a></li>
              <li><a href="/' . $category['slug'] . '">' . $category['title'] . '</a></li>
              <li><span>' . $page->title . '</span></li>
            </ul>
          </div>
          <div class="underhead-consulting-item__cont">
            <div class="underhead-consulting-item__cont-wr">
              <div class="underhead-consulting-item__icon underhead-consulting-item__icon_id_0"></div>
              <h1 class="underhead-consulting-item__title">' . $page->title . '</h1>
              <div class="underhead-consulting-item__txt">' . $page->announce . '</div>
            </div>
          </div>
        </div>
      </section>';
    $title = isset($meta->title) ? $meta->title : $page->title;
    $this->title = $title;


    echo $page->body;

    // echo $this->render('/site/footer');
    ?>
    <?php
} else {
    echo '<h1 class="error-404">There is nothing to display here.</h1>';
}