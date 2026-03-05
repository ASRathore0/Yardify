const fs = require('fs');
let c = fs.readFileSync('resources/views/partials/sidebar.blade.php', 'utf8');

let newSubMenu = `<div id="vendorSubmenu" class="submenu-container" style="display: none;">
              <a href="/vendor/dashboard" class="submenu-item {{ request()->is('vendor/dashboard') ? 'active-sub' : '' }}">
                  <span>Dashboard</span>
              </a>
              <a href="/vendor/bookings" class="submenu-item {{ request()->is('vendor/bookings') ? 'active-sub' : '' }}">
                  <span>Received Bookings</span>
              </a>
              <a href="/vendor" class="submenu-item {{ request()->is('vendor') ? 'active-sub' : '' }}">
                  <span>List Businesses</span>
              </a>
          </div>`;

c = c.replace(/<div id="vendorSubmenu"[\s\S]*?<span>List Businesses<\/span>\s*<\/a>\s*<\/div>/, newSubMenu);
fs.writeFileSync('resources/views/partials/sidebar.blade.php', c);
console.log('done');
