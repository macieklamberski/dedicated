<?php if ($page->total_items): ?>
  <nav class="pagination cf">
    <h2 class="hidden"><?php echo __("Stronicowanie") ?></h2>
    <p>
      <?php echo __('Wyświetlane') ?> <em><?php echo $page->offset + 1 ?>-<?php echo min($page->total_items, $page->offset + $page->items_per_page) ?></em> <?php echo __('z') ?> <em><?php echo $page->total_items ?></em> <?php echo __('rekordów') ?>.
      <?php echo __('Na stronę:') ?>
      <?php echo $page->items_per_page == 15 ? '<em>15</em>' : '<a href="'.URL::site(Request::detect_uri()).URL::query(array('per_page' => 15)).'">15</a>'; ?>,
      <?php echo $page->items_per_page == 30 ? '<em>30</em>' : '<a href="'.URL::site(Request::detect_uri()).URL::query(array('per_page' => 30)).'">30</a>'; ?>,
      <?php echo $page->items_per_page == 90 ? '<em>90</em>' : '<a href="'.URL::site(Request::detect_uri()).URL::query(array('per_page' => 90)).'">90</a>'; ?>,
      <?php echo $page->items_per_page == 2147483647 ? '<em>'.__('wszystkie').'</em>' : '<a href="'.URL::site(Request::detect_uri()).URL::query(array('per_page' => 'all')).'">'.__('wszystkie').'</a>'; ?>.
    </p>
    <ul>
      <?php if ($page->previous_page !== FALSE): ?>
        <li>
          <a class="concave concave-page" href="<?php echo HTML::chars($page->url($page->previous_page)) ?>" rel="prev">
            &laquo; <?php echo __('Poprzednia') ?>
          </a>
        </li>
      <?php else: ?>
        <li class="concave concave-page concave-page-disabled">&laquo; <?php echo __('Poprzednia') ?></li>
      <?php endif ?>

      <?php if ($page->next_page !== FALSE): ?>
        <li class="next">
          <a class="concave concave-page" href="<?php echo HTML::chars($page->url($page->next_page)) ?>" rel="next">
            <?php echo __('Następna') ?> &raquo;
          </a>
        </li>
      <?php else: ?>
        <li class="concave concave-page concave-page-disabled"><?php echo __('Następna') ?> &raquo;</li>
      <?php endif ?>
    </ul>
  </nav>
<?php endif ?>