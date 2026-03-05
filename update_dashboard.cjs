const fs = require('fs');

let c = fs.readFileSync('resources/views/dashboard.blade.php', 'utf8');

// Find the start and end of the second script block that loads vendors
let startIndex = c.indexOf('<script>\n    // Render vendor cards dynamically from API');

if (startIndex !== -1) {
    let endIndex = c.indexOf('</script>', startIndex) + 9;
    c = c.substring(0, startIndex) + c.substring(endIndex);
    fs.writeFileSync('resources/views/dashboard.blade.php', c);
    console.log('Removed dynamic vendor fetching logic from dashboard.');
} else {
    console.log('Logic not found.');
}
