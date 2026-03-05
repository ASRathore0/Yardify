const fs = require('fs');
let content = fs.readFileSync('resources/views/dashboard.blade.php', 'utf8');

content = content.replace(
  '<input\r\n        type="text"\r\n        id="searchInput"\r\n        placeholder="Search for services or your city..."\r\n        class="search-input"',
  '<input\r\n        type="text"\r\n        id="searchInput"\r\n        value="{{ auth()->check() && auth()->user()->city ? auth()->user()->city : session(\'user_location\', \'\') }}"\r\n        placeholder="Search for services or your city..."\r\n        class="search-input"'
);
content = content.replace(
  '<input\n        type="text"\n        id="searchInput"\n        placeholder="Search for services or your city..."\n        class="search-input"',
  '<input\n        type="text"\n        id="searchInput"\n        value="{{ auth()->check() && auth()->user()->city ? auth()->user()->city : session(\'user_location\', \'\') }}"\n        placeholder="Search for services or your city..."\n        class="search-input"'
);

let explore = fs.readFileSync('resources/views/explore.blade.php', 'utf8');
explore = explore.replace(
  /id="searchInput"\s*placeholder="Search services\.\.\."\s*\{\{\s*request\('focus'\)\s*===\s*'search'\s*\?\s*'autofocus'\s*:\s*''\s*\}\}/g,
  'id="searchInput" value="{{ auth()->check() && auth()->user()->city ? auth()->user()->city : session(\'user_location\', \'\') }}" placeholder="Search services..." {{ request(\'focus\') === \'search\' ? \'autofocus\' : \'\' }}'
);

fs.writeFileSync('resources/views/dashboard.blade.php', content, 'utf8');
fs.writeFileSync('resources/views/explore.blade.php', explore, 'utf8');
console.log('Update complete!');
