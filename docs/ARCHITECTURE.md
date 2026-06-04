# ARCHITECTURE

## 1. Общий подход
Минимализм: только файлы, необходимые для работы классической темы. Код совместим с PHP 7.4+.

## 2. Стек технологий
- Frontend: HTML5, Sass (исходники в assets/scss/), сборка в корневой style.css.
- Backend: WordPress (API темы), PHP 7.4+.
- Хранение данных: стандартные таблицы WordPress (при WooCommerce — данные магазина).
- Интеграции: ядро WordPress; совместимость с WooCommerce и Loco Translate (перевод темы).

## 3. Основные модули
- **DOCUMENTATION.md** — руководство для пользователей и разработчиков: логотипы, шорткоды, области виджетов, шаблоны страниц, Sass, перевод, WooCommerce.
- **style.css** — основной файл стилей темы (скомпилирован из assets/scss/style.scss); в начале — метаданные темы для WordPress (Theme Name, Text Domain и т.д.).
- **assets/scss/** — исходники Sass, структурированные по папкам: `base/`, `blocks/`, `elements/`, `pages/`, `shortcodes/`. Главный файл: `style.scss` (подключает все компоненты). Сборка: `npm run build:styles` или `npm run watch:styles`.
- **functions.php** — точка входа, подключает модули из папки `inc/`.
- **inc/** — модули темы: `setup.php` (настройка темы), `enqueues.php` (скрипты и стили), `customizer.php` (настройки Customizer), `widgets.php`, `shortcodes.php`, `helpers.php`, `breadcrumbs.php`, `woocommerce-hooks.php` и др.
- **Шаблоны страниц:** index.php (fallback), page.php (статическая страница), single.php (запись), archive.php (архив), home.php (главная блога), search.php (результаты поиска), 404.php (страница не найдена), page-auth.php (Template Name: Login & Register — фронтенд формы входа/регистрации); page-sidebar-left.php, page-sidebar-right.php, page-sidebar-both.php (шаблоны с левой/правой/обеими боковыми колонками); header.php / footer.php (разметка документа, pre-header и подвал с виджетами); sidebar-left.php, sidebar-right.php; searchform.php; comments.php.
- **Области виджетов (functions.php, widgets_init):** pre-header (над шапкой), footer (подвал), sidebar-left, sidebar-right. Обёртки виджетов: section.widget, заголовок .widget-title.
- **template-parts/content-none.php** — вывод сообщения «ничего не найдено» (подключается из archive, search, home, index).
- **assets/scss/_sidebars.scss** — стили областей виджетов (pre-header, site-header, site-footer), сетка .site-content с колонками (--sidebar-left, --sidebar-right, --sidebar-both), адаптив для узких экранов.
- **assets/scss/_logos.scss** — стили логотипов: .site-branding, .site-logo, .site-logo__img, .brainworks-logo (для вывода шорткода в контенте). Логотипы настраиваются в Customizer (Свойства сайта): Main Logo, Second Logo. Шорткоды [main_logo] и [second_logo] для вывода в контенте.
- **Customizer: секция Phones** — 6 номеров телефонов; для каждого: поле номера (отображаемый формат), поле CSS-класса для ссылки, поле иконки (медиа). Шорткод [phones] с атрибутом format="list|column|dropdown"; ссылки tel: (цифры из номера); вывод иконки перед номером. Функции brainworks_phone_to_tel(), brainworks_get_phones_data().
- **assets/scss/_phones.scss** — стили блока телефонов: .phones, .phones--list, .phones--column, .phones--dropdown, .phones__link, .phones__icon.
- **Customizer: секция Social** — 10 ссылок на соцсети; для каждой: URL (esc_url_raw), иконка (медиа). Шорткод [social] выводит список в один ряд (flex), кликабельные иконки, target="_blank" rel="noopener noreferrer". Функция brainworks_get_social_data().
- **assets/scss/_social.scss** — стили блока соцссылок: .social-links, .social-links__link, .social-links__icon, .social-links__placeholder.
- **Customizer: секция Back to Top Button** — включение кнопки, положение (bottom-right/left), стиль (circle/square/rounded), размер (small/medium/large), кастомная стрелка (медиа). Вывод кнопки в wp_footer; скрипт assets/js/scroll-to-top.js (видимость при скролле, плавный скролл к верху).
- **assets/scss/_scroll-to-top.scss** — стили кнопки «Наверх» и модификаторы.
- **languages/** — каталог для .po/.mo темы (Loco Translate и др.).

## 4. Критические технические решения
- Классическая тема (не FSE/block theme); текстовая область brainworks; поддержка title-tag, html5, post-thumbnails. Поддержка WooCommerce объявляется при наличии класса WooCommerce. Все пользовательские строки темы выводятся через функции перевода с доменом brainworks для совместимости с Loco Translate. Стили пишутся в Sass (assets/scss/style.scss); сборка выводится в корневой style.css; на фронт подключается get_stylesheet_uri() (style.css); версионирование по filemtime для сброса кэша после пересборки.

## 5. Ограничения архитектуры
- Не используем PHP 8-специфичный синтаксис (тема должна работать на PHP 7.4). Не реализуем блоки и theme.json на текущем этапе.
