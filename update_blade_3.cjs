const fs = require('fs');
let dashPath = 'resources/views/dashboard.blade.php';
let dash = fs.readFileSync(dashPath, 'utf8');

dash = dash.replace(
    /(\/\/\s*document\.addEventListener\('DOMContentLoaded',\s*\(\)\s*=>\s*setTimeout\(loadVendorsForSelection,\s*500\)\);)/,
    "      $1\n      document.addEventListener('DOMContentLoaded', () => {\n        const srch = document.getElementById('searchInput');\n        if (srch && srch.value.trim() !== '') setTimeout(loadVendorsForSelection, 500);\n      });"
);

fs.writeFileSync(dashPath, dash, 'utf8');

let expPath = 'resources/views/explore.blade.php';
let exp = fs.readFileSync(expPath, 'utf8');

// Also do it in explore.blade.php just in case it has a similar feature, or just trigger it.
if (exp.includes('loadVendorsForSelection')) {
   exp = exp.replace(
      /(<\/script>\s*<\/body>)/,
      "\n    <script>\n      document.addEventListener('DOMContentLoaded', () => {\n        const srch = document.getElementById('searchInput');\n        if (typeof window.loadVendorsForSelection === 'function' && srch && srch.value.trim() !== '') {\n           setTimeout(window.loadVendorsForSelection, 600);\n        }\n      });\n    </script>\n$1"
   );
   fs.writeFileSync(expPath, exp, 'utf8');
}

console.log('Final touches complete!');