<?php

class View {
   
    protected $_template;
    protected $_data = array();
   
    public function __construct($template)
    {
        if (file_exists($template))
        {
            $this->_template = $template;
        }
        else
        {
            exit('File ' . $template . ' not exists.');
        }
    }
   
    public function __set($key, $value)
    {
        $this->_data[$key] = $value;
    }
   
    public function block($block, array $data = NULL)
    {
        if (file_exists($block))
        {
            if ($data !== NULL) extract($data);
            ob_start();
            require $block;
            $out = ob_get_contents();
            ob_end_clean();
            return $out;
        }
        else
        {
            return 'File ' . $block . ' not exists.';
        }
    }
   
    public function render()
    {
        extract($this->_data);
        require ($this->_template);
    }
   
}


// header('Content-Type: text/html; charset=utf-8');
// // подключаем шаблонизатор и указываем основной шаблон
// $view = new View('./template.html');
// // заголовок и приветствие для примера
// $view->title = 'Тест шаблонизатора';
// $view->hello = 'Добро пожаловать!';
// // создаем массив данных для блока меню
// $data_menu = array(
//     'block_name' => 'Блок меню',
//     'links' => array(
//         'index.php' => 'Главная',
//         'news.php' => 'Новости',
//         'about.php' => 'Контакты',
//     )
// );
// // создаем сам блок меню из подшаблона menu.php и массива данных $data_menu
// $view->block_menu = $view->block('views/menu.php', $data_menu);
// // выводим все на экран
// $view->render();
?>