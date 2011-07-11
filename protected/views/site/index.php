<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<h3>Общая информация:</h3>

<p>В системе реализована базовая ACL. Пользователи делятся на 4 роли: клиенты, работники, управляющие и администраторы системы.</p>
<p>Только администратор может управлять пользователями - просматривать и редактировать. Пароль администратора admin, пароли всех остальных пользователей 123 .</p>
<p>Все зарегистрированные пользователи могут просматривать только свои документы и скачивать файлы.</p>
<p>Все пользователи обладают одинаковыми привилегиям, но вначале я сделал так, чтобы клиенты не могли создавать, редактировать и удалять документы. Чтобы вернуться к этому режиму нужно просто раскомментировать два блока в DocsController.php и закомментировать самый первый блок.</p>
<p>Дефолтная сортировка для документов по дате по убыванию. Пагинация для документов - 8 строк на страницу. Лучше всего и первое и второе отображается в документах для служащих (helen или ann), т.к. для них я вбил 12 документов..</p>

<h3>Инструкция:</h3>

<ol>
<li>Для того, чтобы увидеть список документов нужно <?php echo CHtml::link('залогиниться', array('/site/login')); ?>. </li>
<li>Далее нужно пройти непосредственно к <?php echo CHtml::link('списку', array('/docs')); ?>. </li>
<li>Зайдя админом можно <?php echo CHtml::link('редактировать юзеров', array('/users')); ?>. </li>
</ol>

<hr>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <tt><?php echo __FILE__; ?></tt></li>
	<li>Layout file: <tt><?php echo $this->getLayoutFile('main'); ?></tt></li>
</ul>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p>
