const fs = require('fs');
const css = fs.readFileSync('resources/css/app.css', 'utf8');
const lines = css.split('\n');
let inBlock = false, start = 0, depth = 0;
const results = [];

for (let i = 0; i < lines.length; i++) {
    const l = lines[i].trim();
    if (l === '.products-filter-sidebar {') {
        inBlock = true;
        start = i;
        depth = 1;
    } else if (inBlock) {
        if (l.includes('{')) depth++;
        if (l.includes('}')) {
            depth--;
            if (depth === 0) {
                inBlock = false;
                const block = lines.slice(start, i + 1).join('\n');
                if (block.includes('position: fixed') || block.includes('position:fixed')) {
                    results.push({ line: start + 1, endLine: i + 1, block });
                }
            }
        }
    }
}

results.forEach((r, i) => {
    console.log(`Rule ${i + 1}: lines ${r.line}-${r.endLine}`);
    console.log(r.block.substring(0, 300));
    console.log('---');
});
