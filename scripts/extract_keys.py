import re
import os
from pathlib import Path

BASE = Path("resources/views")
keys = set()

for blade in BASE.rglob("*.blade.php"):
    content = blade.read_text(encoding="utf-8", errors="ignore")
    # Match __(...) and @lang(...) patterns
    for m in re.finditer(r"__\(['\"]([\w.]+)['\"]", content):
        keys.add(m.group(1))
    for m in re.finditer(r"@lang\(['\"]([\w.]+)['\"]\)", content):
        keys.add(m.group(1))
    # Also @choice(...)
    for m in re.finditer(r"@choice\(['\"]([\w.]+)['\"]", content):
        keys.add(m.group(1))

# Sort and print
print(f"Total unique keys: {len(keys)}")
for k in sorted(keys):
    print(k)
