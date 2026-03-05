const fs = require('fs');

// dashboard.blade.php
let dashPath = 'resources/views/dashboard.blade.php';
let dash = fs.readFileSync(dashPath, 'utf8');
dash = dash.replace(
    /<input\s+type="text"\s+id="searchInput"/g, 
    '<input type="text" id="searchInput" value="{{ auth()->check() && auth()->user()->city ? auth()->user()->city : session(\'user_location\', \'\') }}"'
);
fs.writeFileSync(dashPath, dash, 'utf8');

// explore.blade.php
let expPath = 'resources/views/explore.blade.php';
let exp = fs.readFileSync(expPath, 'utf8');
exp = exp.replace(
    /<input\s+type="text"\s+id="searchInput"/g,
    '<input type="text" id="searchInput" value="{{ auth()->check() && auth()->user()->city ? auth()->user()->city : session(\'user_location\', \'\') }}"'
);
fs.writeFileSync(expPath, exp, 'utf8');

console.log('Done replacement!');