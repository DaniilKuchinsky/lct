<?php

use hail812\adminlte\widgets\Menu;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Админка</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo Menu::widget([
                                  'items' => [
                                      [
                                          'label' => 'Пользователи',
                                          'icon'  => 'user-friends',
                                          'url'   => ['user/index'],
                                          'active' => $this->context->id == 'user',
                                      ],
                                      [
                                          'label' => 'Стандарт Москвы',
                                          'icon'  => 'th',
                                          'url'   => ['standard-moscow/index'],
                                          'active' => $this->context->id == 'standard-moscow',
                                      ],
                                      [
                                          'label' => 'Консультации',
                                          'icon'  => 'th',
                                          'url'   => ['consultation/index'],
                                          'active' => $this->context->id == 'consultation',
                                      ],
                                      [
                                          'label' => 'События',
                                          'icon'  => 'th',
                                          'url'   => ['log-event/index'],
                                          'active' => $this->context->id == 'log-event',
                                      ],
                                  ],
                              ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>