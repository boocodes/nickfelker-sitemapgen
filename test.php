<?php

    require_once('./src/app/generator.php');

    $map_generator = new MapGenerator();
    $map_generator->set_file_generation_type('xml');
    $map_generator->set_file_path('./result');
    $map_generator->set_folder_creating_flag(true);
    $map_generator->set_sitename('test.com');

    $map_generator->add_page(array('loc' => 'https://test.com/news', 'lastmod' => '2020-12-14', 'priority' => '1', 'changefreq' => 'hourly'));
    $map_generator->add_page(array('loc' => 'https://test.com/about', 'lastmod' => '2020-12-15', 'priority' => '0.5', 'changefreq' => 'hourly'));
    $map_generator->add_page(array('loc' => 'https://test.com/main', 'lastmod' => '2020-12-21', 'priority' => '1', 'changefreq' => 'daily'));

    $map_generator->create_map();


    $map_generator->set_file_generation_type('json');
    $map_generator->create_map();

    $map_generator->set_file_generation_type('csv');
    $map_generator->create_map();