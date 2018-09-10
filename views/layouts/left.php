<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Справочник BIO', 'icon' => 'bold', 'url' => ['/bio']],
                    ['label' => 'Список ФИО', 'icon' => 'check', 'url' => ['/fio']],
                ]
            ]
        )?>

    </section>

</aside>
