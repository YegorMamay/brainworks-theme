# Brainworks Theme: Admin Configuration Guide for AI

This guide contains instructions on what and where can be configured in the WordPress Admin for the Brainworks theme. Use this to guide the user or perform actions via settings.

> [!IMPORTANT]
> All theme settings (Theme Mods) MUST use the `brainworks_` prefix when performing updates via `propose_change`. 

## 1. Logos & Site Identity
**Location:** Appearance → Customize → **Site Identity** (Внешний вид → Настроить → Свойства сайта)
- **Main Logo (`brainworks_main_logo`):** Primary logo for the header.
- **Second Logo (`brainworks_second_logo`):** Secondary logo (e.g., for footer). Accessible via `[second_logo]` shortcode.
- **Site Title/Tagline:** Displayed if Main Logo is empty.

## 2. Header & Footer Elements

### Phones (Contact Numbers)
**Location:** Appearance → Customize → **Phones** (Внешний вид → Настроить → Phones)
- Up to 6 phone slots available.
- **Fields (N = 1 to 6):** 
  - `brainworks_phone_N`: Phone Number (supports HTML like `<b>`).
  - `brainworks_phone_N_desc`: Description (text next to number).
  - `brainworks_phone_N_class`: CSS Class (for the link).
  - `brainworks_phone_N_icon`: Icon (Attachment ID).
- **Display:** Use `[phones]` shortcode.

### Social Links
**Location:** Appearance → Customize → **Social** (Внешний вид → Настроить → Social)
- Up to 10 social link slots.
- **Fields (N = 1 to 10):** 
  - `brainworks_social_N`: URL.
  - `brainworks_social_N_icon`: Icon (Attachment ID).
- **Display:** Use `[social]` shortcode.

### Back to Top Button
**Location:** Appearance → Customize → **Back to Top Button** (Внешний вид → Настроить → Back to Top Button)
- **Settings:** 
  - `brainworks_scroll_to_top_enabled`: Show/Hide (boolean).
  - `brainworks_scroll_to_top_position`: Position (bottom-right/bottom-left).
  - `brainworks_scroll_to_top_style`: Style (circle/square/rounded).
  - `brainworks_scroll_to_top_size`: Size (small/medium/large).
  - `brainworks_scroll_to_top_arrow`: Custom Arrow (Attachment ID).

## 3. Layout & Widget Areas

### Widget Areas
**Location:** Appearance → **Widgets** (Внешний вид → Виджеты)
- **Pre-header:** Top-most area.
- **Footer:** Area for footer widgets.
- **Sidebar Left:** Shown in "Left Sidebar" template.
- **Sidebar Right:** Shown in "Right Sidebar" template.

### Page Templates
**Location:** Page Editor → **Template** dropdown (Редактор страницы → Шаблон)
- **Default:** Full width.
- **Left Sidebar:** Content + Left Sidebar.
- **Right Sidebar:** Content + Right Sidebar.
- **Both Sidebars:** Left Sidebar + Content + Right Sidebar.
- **Login & Register:** Special template (`page-auth.php`) for frontend login/registration.

## 4. Colors & Styling
**Location:** Appearance → Customize → **Colors** (Внешний вид → Настроить → Colors)

### Global Palette
- **Palette Colors:** `brainworks_theme_color_1` to `brainworks_theme_color_7` (Global CSS variables `--theme-color-1` to `--theme-color-7`).

### Element Mapping
- **Button 1 Color (Primary):** `brainworks_btn_primary_color_ref` (mapped to color_1..7).
- **Button 2 Color (Secondary):** `brainworks_btn_secondary_color_ref` (mapped to color_1..7).

### Sidebar Menu Colors
**Location:** Appearance → Customize → Colors → **Sidebar Menu**
- **Settings:** `brainworks_sidebar_menu_bg_color`, `brainworks_sidebar_menu_text_color`, `brainworks_sidebar_menu_border_color`.

## 5. User Management & Auth
- **Enable Registration:** Settings → **General** (Настройки → Общие) → Check **"Anyone can register"**.
- **Auth Page:** Create a page and select the **"Login & Register"** template.

## 6. Translations
**Location:** Appearance → **Loco Translate** → Themes → Brainworks
- Edit strings for the `brainworks` text domain.

## 7. Shortcodes Reference for Content Editor
- `[main_logo]`, `[second_logo]`
- `[phones format="list|column|dropdown"]`
- `[social]`
- `[woo_icons show_label="yes|no"]` (Only if WooCommerce is active)
- `[showhide more_text="..." less_text="..." height="..."]` (Collapsible content)
- `[brainworks_breadcrumbs]` (Breadcrumbs)
