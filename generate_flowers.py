"""
Verdant Silence — Floral Image Generator
Creates botanical, moody flower images matching the Verdant Silence aesthetic.
All flowers are procedurally generated with Pillow — no external assets required.
"""
import os
import math
import random
from PIL import Image, ImageDraw, ImageFilter, ImageEnhance
from functools import lru_cache

# ─── Paths ───────────────────────────────────────────────────────────────────
BASE = r"c:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\public\images"

PATHS = {
    # Decorative / hero / banners
    "hero/hero-bg":               (1920, 1080),
    "products/hero-banner":        (1920, 600),
    "categories/category-hero":    (1920, 500),
    "navbar/navbar-featured":     (800, 500),
    # Categories
    "categories/category-1":      (800, 1000),
    "categories/category-2":      (800, 1000),
    "categories/banner":          (1200, 600),
    "categories/banner-2":       (1200, 600),
    "categories/category-show-default": (1200, 600),
    "categories/category-default": (800, 1000),
    # Products (used as category images too)
    "products/roses":             (800, 1000),
    "products/flowers-1":        (800, 1000),
    "products/flowers-2":        (800, 1000),
    "products/flowers-3":        (800, 1000),
    "products/flowers-5":        (800, 1000),
    "products/flowers-6":        (800, 1000),
    # Detail editorial
    "detail/detail-1":            (1200, 800),
    "detail/detail-3":           (1200, 800),
    "detail/detail-4":           (1200, 800),
}

random.seed(42)

# ─── Palette ────────────────────────────────────────────────────────────────
DEEP_GREEN     = (18, 35, 22)
DEEP_BURGUNDY  = (28, 18, 22)
DEEP_NAVY      = (16, 18, 32)
DEEP_WARM      = (22, 18, 16)
DEEP_PURPLE    = (22, 16, 28)

BG_PALETTE = [DEEP_GREEN, DEEP_BURGUNDY, DEEP_NAVY, DEEP_WARM, DEEP_PURPLE]

# Muted flower colours — all desaturated, gentle
FLOWER_PALETTES = [
    # Blush + cream
    [(240, 200, 192), (235, 215, 208), (245, 235, 230), (218, 178, 168), (255, 248, 242)],
    # Sage + lavender
    [(168, 184, 154), (188, 200, 175), (200, 210, 195), (148, 164, 134), (210, 215, 205)],
    # Terracotta + cream
    [(196, 131, 106), (215, 158, 130), (225, 178, 152), (175, 110, 85), (235, 195, 172)],
    # Warm rose + blush
    [(210, 155, 165), (225, 175, 185), (240, 200, 208), (188, 128, 142), (248, 215, 222)],
    # Lavender + cream
    [(184, 168, 196), (198, 182, 208), (212, 198, 222), (162, 144, 178), (228, 214, 235)],
    # Gold + cream
    [(198, 172, 108), (215, 188, 122), (228, 205, 142), (175, 148, 82), (240, 220, 165)],
    # Cream + white
    [(245, 238, 228), (255, 250, 244), (238, 228, 215), (250, 244, 232), (255, 252, 248)],
    # Peach + warm
    [(228, 178, 158), (238, 192, 172), (245, 205, 188), (215, 160, 138), (248, 210, 195)],
]

STEM_COLORS = [(55, 82, 48), (48, 72, 42), (65, 95, 55), (40, 62, 38)]
LEAF_COLORS = [(45, 72, 40), (55, 85, 48), (38, 62, 35), (60, 90, 52)]

# ─── Helpers ─────────────────────────────────────────────────────────────────

def clamp(v, lo=0, hi=255):
    return max(lo, min(hi, int(v)))

def lerp(a, b, t):
    return tuple(clamp(a[i] + (b[i] - a[i]) * t) for i in range(len(a)))

def darken(c, f=0.35):
    return tuple(clamp(x * f) for x in c)

def lighten(c, f=1.45):
    return tuple(clamp(x * f) for x in c)

def soft_edge(draw, cx, cy, rx, ry, color, alpha=220):
    """Draw a soft blurred ellipse (glow effect)."""
    pass  # we'll use blur instead

def radial_glow(size, center_color, edge_color=(0,0,0), cx=None, cy=None, radius_factor=0.45):
    """Create a radial gradient image (dark edges, lit center)."""
    w, h = size
    cx = cx if cx is not None else w * 0.5
    cy = cy if cy is not None else h * 0.5
    rx = w * radius_factor
    ry = h * radius_factor

    img = Image.new("RGB", size, edge_color)
    max_dist = math.sqrt(rx**2 + ry**2)

    for y in range(h):
        for x in range(w):
            dx = (x - cx) / rx
            dy = (y - cy) / ry
            dist = math.sqrt(dx*dx + dy*dy)
            t = max(0.0, 1.0 - dist)
            t = t ** 1.6  # softer falloff
            img.putpixel((x, y), lerp(edge_color, center_color, t))

    return img

def add_vignette(img, strength=0.75):
    """Darken corners for moody vignette effect."""
    w, h = img.size
    overlay = Image.new("RGB", img.size, (0, 0, 0))
    draw = ImageDraw.Draw(overlay)

    cx, cy = w * 0.5, h * 0.5
    max_d = math.sqrt(cx**2 + cy**2)

    for y in range(0, h, 4):
        for x in range(0, w, 4):
            dx = (x - cx) / (w * 0.5)
            dy = (y - cy) / (h * 0.5)
            d = math.sqrt(dx*dx + dy*dy)
            t = min(1.0, d * strength)
            t = t ** 1.5
            alpha = int(t * 220)
            if alpha > 0:
                overlay.putpixel((x, y), (0, 0, 0))
                # draw a small block
                for dy2 in range(min(4, h - y)):
                    for dx2 in range(min(4, w - x)):
                        try:
                            px = img.getpixel((x+dx2, y+dy2))
                            img.putpixel((x+dx2, y+dy2),
                                         lerp(px, (0, 0, 0), t * 0.6))
                        except:
                            pass
    return img

def add_noise(img, amount=12):
    """Add fine film grain."""
    w, h = img.size
    pixels = img.load()
    for y in range(h):
        for x in range(w):
            p = pixels[x, y]
            n = random.randint(-amount, amount)
            pixels[x, y] = tuple(clamp(p[i] + n) for i in range(3))
    return img

def bezier(p0, p1, p2, p3, t):
    u = 1 - t
    return (
        u**3*p0[0] + 3*u**2*t*p1[0] + 3*u*t**2*p2[0] + t**3*p3[0],
        u**3*p0[1] + 3*u**2*t*p1[1] + 3*u*t**2*p2[1] + t**3*p3[1],
    )

def draw_organic_blob(img, cx, cy, rx, ry, n_points=8, color=(40,60,35)):
    """Draw a softly filled organic blob on the image."""
    points = []
    offsets = [random.uniform(0.7, 1.3) for _ in range(n_points)]
    for i in range(n_points):
        angle = 2 * math.pi * i / n_points
        px = cx + math.cos(angle) * rx * offsets[i]
        py = cy + math.sin(angle) * ry * offsets[i]
        points.append((px, py))
    draw = ImageDraw.Draw(img)
    try:
        draw.polygon(points, fill=color)
    except Exception:
        pass
    return points

def draw_petal(draw, cx, cy, angle, length, width, color, edge_color=None, alpha=230):
    """Draw a single petal using bezier curves."""
    import math
    rad = math.radians(angle)
    tip_x = cx + math.sin(rad) * length
    tip_y = cy - math.cos(rad) * length

    base_l_x = cx + math.sin(rad - 0.4) * length * 0.3
    base_l_y = cy - math.cos(rad - 0.4) * length * 0.3
    base_r_x = cx + math.sin(rad + 0.4) * length * 0.3
    base_r_y = cy - math.cos(rad + 0.4) * length * 0.3

    cp1x = cx + math.sin(rad - 0.3) * length * 0.75
    cp1y = cy - math.cos(rad - 0.3) * length * 0.75
    cp2x = tip_x
    cp2y = tip_y

    # Build petal polygon
    pts_top = [bezier((base_l_x, base_l_y), (cp1x, cp1y), (tip_x, tip_y), (tip_x, tip_y), t)
               for t in [i/20 for i in range(21)]]
    cp1x2 = cx + math.sin(rad + 0.3) * length * 0.75
    cp1y2 = cy - math.cos(rad + 0.3) * length * 0.75
    pts_bot = [bezier((tip_x, tip_y), (cp1x2, cp1y2), (base_r_x, base_r_y), (base_r_x, base_r_y), t)
               for t in [i/20 for i in range(21)]]

    all_pts = pts_top + pts_bot[1:-1] + [(base_l_x, base_l_y)]
    try:
        draw.polygon(all_pts, fill=color)
    except Exception:
        pass
    if edge_color:
        try:
            draw.point(all_pts, fill=edge_color)
        except Exception:
            pass

def draw_leaf(draw, cx, cy, angle, length, width, color):
    """Draw a leaf using bezier."""
    import math
    rad = math.radians(angle)
    tip_x = cx + math.sin(rad) * length
    tip_y = cy - math.cos(rad) * length
    mid_x = cx + math.sin(rad) * length * 0.5
    mid_y = cy - math.cos(rad) * length * 0.5

    perp = rad + math.pi / 2
    l_x = mid_x + math.sin(perp) * width * 0.5
    l_y = mid_y - math.cos(perp) * width * 0.5
    r_x = mid_x - math.sin(perp) * width * 0.5
    r_y = mid_y + math.cos(perp) * width * 0.5

    p0 = (cx, cy)
    p1 = (l_x, l_y)
    p2 = (tip_x, tip_y)
    p3 = (r_x, r_y)

    top_half = [bezier(p0, p1, p2, p2, t) for t in [i/30 for i in range(31)]]
    bot_half = [bezier(p2, p3, p0, p0, t) for t in [i/30 for i in range(31)]]
    all_pts = top_half + bot_half[1:-1]
    try:
        draw.polygon(all_pts, fill=color)
    except Exception:
        pass

def draw_stem(draw, x1, y1, x2, y2, color, width=3):
    try:
        draw.line([(x1, y1), (x2, y2)], fill=color, width=width)
    except Exception:
        pass

def draw_center_circle(draw, cx, cy, r, color, highlight=None):
    try:
        draw.ellipse([cx-r, cy-r, cx+r, cy+r], fill=color)
        if highlight:
            hx, hy = cx - r*0.25, cy - r*0.25
            hr = r * 0.35
            draw.ellipse([hx-hr, hy-hr, hx+hr, hy+hr], fill=highlight)
    except Exception:
        pass

def draw_stamens(draw, cx, cy, n, r, color, tip_color):
    import math
    for i in range(n):
        angle = 2 * math.pi * i / n + random.uniform(-0.2, 0.2)
        x = cx + math.cos(angle) * r
        y = cy + math.sin(angle) * r
        try:
            draw.line([(cx + math.cos(angle)*r*0.4, cy + math.sin(angle)*r*0.4), (x, y)],
                      fill=color, width=1)
            draw.ellipse([x-2, y-2, x+2, y+2], fill=tip_color)
        except Exception:
            pass

# ─── Flower Generators ──────────────────────────────────────────────────────

def make_rose(w, h, palette_idx=3, seed_val=1):
    """Multi-layered romantic rose."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.42

    # Background gradient
    img = radial_glow((w, h), darken(bg_color, 0.55), bg_color,
                      cx=w*0.5, cy=h*0.38, radius_factor=0.52)
    draw = ImageDraw.Draw(img)

    # Subtle organic background blobs
    for _ in range(4):
        bx = random.uniform(w*0.1, w*0.9)
        by = random.uniform(h*0.1, h*0.9)
        brx = random.uniform(w*0.08, w*0.2)
        bry = random.uniform(h*0.12, h*0.25)
        blob_c = darken(bg_color, 0.4)
        draw_organic_blob(img, bx, by, brx, bry, n_points=random.randint(6,10),
                           color=blob_c)

    # Stems
    for i in range(3):
        sx = w * (0.35 + i * 0.15) + random.uniform(-15, 15)
        sy1 = h * 0.88
        sy2 = h * (0.55 + i * 0.04)
        sc = STEM_COLORS[(seed_val + i) % len(STEM_COLORS)]
        draw_stem(draw, sx, sy1, sx + random.uniform(-8, 8), sy2, sc, width=2)

    # Leaves
    for i in range(6):
        lx = w * (0.25 + random.uniform(0, 0.5))
        ly = h * (0.58 + random.uniform(0, 0.25))
        la = random.uniform(50, 130)
        ll = random.uniform(h*0.06, h*0.11)
        lw = random.uniform(w*0.02, w*0.035)
        lc = LEAF_COLORS[(seed_val + i) % len(LEAF_COLORS)]
        draw_leaf(draw, lx, ly, la, ll, lw, lc)

    # Main rose — layers from outside in
    petal_colors = [pal[1], pal[0], pal[2], pal[0], pal[3], pal[0], pal[4]]
    petal_sizes = [0.42, 0.35, 0.28, 0.22, 0.17, 0.13, 0.08]
    petal_counts = [8, 7, 6, 6, 5, 5, 1]
    petal_offsets = [8, 12, 18, 24, 30, 36, 0]

    for layer, (pc, ps, po, pcol) in enumerate(zip(petal_counts, petal_sizes, petal_offsets, petal_colors)):
        r = min(w, h) * ps
        for i in range(pc):
            angle = 360 / pc * i + po + random.uniform(-3, 3)
            draw_petal(draw, cx, cy, angle, r, r * 0.42, pcol,
                       edge_color=darken(pcol, 0.7), alpha=235)

    # Inner swirl
    inner_angle = 0
    for i in range(18):
        angle = inner_angle + i * 20
        r = min(w, h) * (0.07 + i * 0.006)
        col = lerp(pal[0], pal[4], i / 18)
        draw_petal(draw, cx, cy, angle, r, r * 0.35, col, alpha=240)

    # Center
    draw_center_circle(draw, cx, cy, min(w,h)*0.04, pal[0], lighten(pal[0], 1.3))
    draw_stamens(draw, cx, cy, 12, min(w,h)*0.03, darken(pal[0],0.6), lighten(pal[3], 1.4))

    img = add_vignette(img, strength=0.8)
    img = add_noise(img, amount=8)
    return img


def make_peony(w, h, palette_idx=0, seed_val=10):
    """Full, lush peony — many layered petals."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.45

    img = radial_glow((w, h), darken(bg_color, 0.5), bg_color,
                      cx=w*0.5, cy=h*0.42, radius_factor=0.5)
    draw = ImageDraw.Draw(img)

    # Background organic shapes
    for _ in range(5):
        bx = random.uniform(w*0.1, w*0.9)
        by = random.uniform(h*0.1, h*0.9)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.07, w*0.18),
                          random.uniform(h*0.1, h*0.22),
                          n_points=random.randint(6,10),
                          color=darken(bg_color, 0.38))

    # Stems
    for i in range(3):
        sx = w * (0.38 + i * 0.12) + random.uniform(-12, 12)
        sy1 = h * 0.9
        sy2 = h * (0.58 + i * 0.03)
        draw_stem(draw, sx, sy1, sx + random.uniform(-6, 6), sy2,
                  STEM_COLORS[(seed_val+i)%len(STEM_COLORS)], width=2)

    # Leaves
    for i in range(8):
        lx = w * random.uniform(0.2, 0.75)
        ly = h * random.uniform(0.55, 0.88)
        draw_leaf(draw, lx, ly, random.uniform(60, 120),
                  random.uniform(h*0.07, h*0.13),
                  random.uniform(w*0.025, w*0.04),
                  LEAF_COLORS[(seed_val+i)%len(LEAF_COLORS)])

    # Peony petals — many layers
    n_layers = 10
    for layer in range(n_layers):
        t = layer / n_layers
        n_petals = 10 - int(t * 4)
        r = min(w, h) * (0.45 - t * 0.38)
        angle_offset = layer * 5 + random.uniform(-2, 2)
        pcol = lerp(pal[0], pal[2], t)
        for i in range(n_petals):
            angle = 360 / n_petals * i + angle_offset
            draw_petal(draw, cx, cy, angle, r, r * 0.48, pcol,
                       edge_color=darken(pcol, 0.65), alpha=235)

    # Fluffy center
    draw_center_circle(draw, cx, cy, min(w,h)*0.06, lerp(pal[1], pal[0], 0.5))
    for _ in range(24):
        px = cx + random.uniform(-w*0.05, w*0.05)
        py = cy + random.uniform(-h*0.05, h*0.05)
        pr = random.uniform(2, 5)
        try:
            draw.ellipse([px-pr, py-pr, px+pr, py+pr], fill=lerp(pal[1], pal[0], random.random()))
        except:
            pass

    img = add_vignette(img, strength=0.78)
    img = add_noise(img, amount=8)
    return img


def make_tulip(w, h, palette_idx=2, seed_val=20):
    """Elegant elongated tulip — three outer petals, visible stem."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.4

    img = radial_glow((w, h), darken(bg_color, 0.52), bg_color,
                      cx=w*0.5, cy=h*0.38, radius_factor=0.5)
    draw = ImageDraw.Draw(img)

    # Background blobs
    for _ in range(3):
        bx = random.uniform(w*0.1, w*0.9)
        by = random.uniform(h*0.2, h*0.8)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.06, w*0.14),
                          random.uniform(h*0.1, h*0.18),
                          color=darken(bg_color, 0.4))

    # Stem
    sx = cx + random.uniform(-10, 10)
    draw_stem(draw, sx, cy + min(w,h)*0.18, sx + random.uniform(-5, 5), h * 0.88,
              STEM_COLORS[(seed_val)%len(STEM_COLORS)], width=3)

    # Leaves
    for i in range(2):
        lx = sx + (-1)**i * random.uniform(w*0.04, w*0.08)
        ly = cy + min(w,h)*0.22 + i * h*0.1
        draw_leaf(draw, lx, ly, 80 + i*20,
                  h * 0.18, w * 0.035,
                  LEAF_COLORS[(seed_val+i)%len(LEAF_COLORS)])

    # Tulip petals — 3 overlapping elongated petals
    petal_defs = [
        (0, min(w,h)*0.32, pal[0]),
        (120, min(w,h)*0.30, pal[1]),
        (240, min(w,h)*0.32, pal[0]),
    ]
    for angle, length, color in petal_defs:
        draw_petal(draw, cx, cy, angle, length, length * 0.28, color,
                   edge_color=darken(color, 0.7), alpha=235)
        # Inner petal
        draw_petal(draw, cx, cy, angle + 3, length * 0.88, length * 0.2,
                   lighten(color, 1.1), alpha=230)

    # Center line
    for dy in range(int(cy - min(w,h)*0.28), int(cy)):
        try:
            draw.point((cx + random.uniform(-1, 1), dy), fill=darken(pal[1], 0.7))
        except:
            pass

    img = add_vignette(img, strength=0.75)
    img = add_noise(img, amount=7)
    return img


def make_lavender(w, h, palette_idx=4, seed_val=30):
    """Delicate lavender sprig with many small buds."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.5

    img = radial_glow((w, h), darken(bg_color, 0.48), bg_color,
                      cx=w*0.5, cy=h*0.45, radius_factor=0.5)
    draw = ImageDraw.Draw(img)

    # Background blobs
    for _ in range(4):
        bx = random.uniform(w*0.1, w*0.9)
        by = random.uniform(h*0.1, h*0.9)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.06, w*0.12),
                          random.uniform(h*0.1, h*0.18),
                          color=darken(bg_color, 0.4))

    n_stalks = 7
    for si in range(n_stalks):
        angle = -90 + (si - n_stalks/2) * 8 + random.uniform(-4, 4)
        sx = cx + (si - n_stalks/2) * w * 0.06
        sy1 = h * 0.82
        sy2 = h * 0.18
        draw_stem(draw, sx, sy1, sx + random.uniform(-5, 5), sy2,
                  STEM_COLORS[(seed_val+si)%len(STEM_COLORS)], width=1)

        # Lavender buds along stalk
        n_buds = 14
        for bi in range(n_buds):
            t = bi / n_buds
            bx = sx + math.sin(math.radians(angle)) * (sy1 - sy2) * t * 0.0 + random.uniform(-4, 4)
            by = sy1 - (sy1 - sy2) * t
            br = random.uniform(3, 6)
            bud_c = lerp(pal[0], pal[2], t * 0.7 + random.uniform(0, 0.3))
            try:
                draw.ellipse([bx-br, by-br*1.6, bx+br, by+br*1.6], fill=bud_c)
            except:
                pass

    # Small leaves at base
    for i in range(4):
        lx = cx + random.uniform(-w*0.15, w*0.15)
        ly = h * 0.75 + random.uniform(0, h*0.12)
        draw_leaf(draw, lx, ly, random.uniform(70, 110),
                  h * 0.08, w * 0.02,
                  LEAF_COLORS[(seed_val+i)%len(LEAF_COLORS)])

    img = add_vignette(img, strength=0.72)
    img = add_noise(img, amount=6)
    return img


def make_sunflower(w, h, palette_idx=5, seed_val=40):
    """Bold sunflower with dark center and radiating petals."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.45

    img = radial_glow((w, h), darken(bg_color, 0.55), bg_color,
                      cx=w*0.5, cy=h*0.4, radius_factor=0.5)
    draw = ImageDraw.Draw(img)

    for _ in range(4):
        bx = random.uniform(w*0.1, w*0.9)
        by = random.uniform(h*0.1, h*0.9)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.07, w*0.15),
                          random.uniform(h*0.1, h*0.2),
                          color=darken(bg_color, 0.4))

    # Stem
    sx = cx + random.uniform(-8, 8)
    draw_stem(draw, sx, cy + min(w,h)*0.22, sx, h * 0.88,
              STEM_COLORS[(seed_val)%len(STEM_COLORS)], width=3)
    # Leaves
    for i in range(4):
        lx = sx + (-1)**i * w*0.08
        ly = h * (0.62 + i*0.08)
        draw_leaf(draw, lx, ly, 70 + i*15,
                  h * 0.12, w * 0.04,
                  LEAF_COLORS[(seed_val+i)%len(LEAF_COLORS)])

    # Petals — two layers
    r = min(w, h) * 0.36
    for i in range(20):
        angle = 360 / 20 * i
        draw_petal(draw, cx, cy, angle, r, r * 0.22, pal[1],
                   edge_color=darken(pal[1], 0.7), alpha=235)
    # Inner petals
    for i in range(20):
        angle = 360 / 20 * i + 9
        draw_petal(draw, cx, cy, angle, r * 0.75, r * 0.18, pal[2],
                   alpha=230)

    # Dark center with pattern
    cr = min(w, h) * 0.14
    draw_center_circle(draw, cx, cy, cr, darken(pal[5] if len(pal)>5 else pal[0], 0.4))
    for ring in range(4):
        rr = cr * (0.3 + ring * 0.22)
        n_dots = 16 + ring * 8
        for i in range(n_dots):
            a = 2 * math.pi * i / n_dots
            dx = cx + math.cos(a) * rr
            dy = cy + math.sin(a) * rr
            try:
                draw.ellipse([dx-2, dy-2, dx+2, dy+2],
                             fill=lighten(pal[5] if len(pal)>5 else pal[0], 1.3))
            except:
                pass

    img = add_vignette(img, strength=0.8)
    img = add_noise(img, amount=9)
    return img


def make_orchid(w, h, palette_idx=4, seed_val=50):
    """Ethereal orchid with wide flat petals and labellum."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.48

    img = radial_glow((w, h), darken(bg_color, 0.5), bg_color,
                      cx=w*0.5, cy=h*0.44, radius_factor=0.5)
    draw = ImageDraw.Draw(img)

    for _ in range(4):
        bx = random.uniform(w*0.1, w*0.9)
        by = random.uniform(h*0.1, h*0.9)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.08, w*0.16),
                          random.uniform(h*0.12, h*0.2),
                          color=darken(bg_color, 0.4))

    # Stem curve
    sx = cx + random.uniform(-15, 15)
    sy1 = h * 0.88
    sy2 = h * 0.52
    draw_stem(draw, sx, sy1, sx + random.uniform(-10, 10), sy2,
              STEM_COLORS[(seed_val)%len(STEM_COLORS)], width=2)

    # 3 outer wide petals
    petal_defs = [(0, 0.35, pal[0]), (144, 0.32, pal[1]), (216, 0.35, pal[0])]
    for angle, size, color in petal_defs:
        draw_petal(draw, cx, cy, angle, min(w,h)*size, min(w,h)*size*0.5,
                   color, edge_color=darken(color, 0.7), alpha=235)

    # Side petals — more vertical
    for sign in [-1, 1]:
        draw_petal(draw, cx, cy, 72 * sign, min(w,h)*0.28, min(w,h)*0.22,
                   pal[2], alpha=230)

    # Labellum (center lip)
    lr = min(w, h) * 0.18
    draw_center_circle(draw, cx, cy, lr, lerp(pal[3], pal[0], 0.5))
    # Lip detail
    for _ in range(8):
        lx = cx + random.uniform(-lr*0.8, lr*0.8)
        ly = cy + random.uniform(-lr*0.6, lr*0.6)
        try:
            draw.ellipse([lx-2, ly-2, lx+2, ly+2],
                        fill=lighten(pal[3], 1.5))
        except:
            pass

    # Column (stamen/pistil structure)
    col_h = min(w, h) * 0.12
    try:
        draw.ellipse([cx-4, cy-col_h, cx+4, cy], fill=lighten(pal[1], 1.2))
    except:
        pass

    img = add_vignette(img, strength=0.75)
    img = add_noise(img, amount=7)
    return img


def make_branch_blossom(w, h, palette_idx=6, seed_val=60):
    """Cherry blossom branch — delicate pink clusters on dark branch."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)

    img = radial_glow((w, h), darken(bg_color, 0.52), bg_color,
                      cx=w*0.5, cy=h*0.45, radius_factor=0.5)
    draw = ImageDraw.Draw(img)

    for _ in range(5):
        bx = random.uniform(w*0.05, w*0.95)
        by = random.uniform(h*0.05, h*0.95)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.08, w*0.15),
                          random.uniform(h*0.12, h*0.2),
                          color=darken(bg_color, 0.38))

    # Main branch
    pts = [(w*0.1, h*0.9), (w*0.3, h*0.65), (w*0.5, h*0.45),
           (w*0.7, h*0.28), (w*0.88, h*0.12)]
    for i in range(len(pts)-1):
        draw_stem(draw, pts[i][0], pts[i][1],
                  pts[i+1][0], pts[i+1][1],
                  darken(DEEP_BURGUNDY, 0.6), width=4)

    # Sub-branches
    sub_pts = [
        [(w*0.25, h*0.7), (w*0.15, h*0.55), (w*0.08, h*0.42)],
        [(w*0.45, h*0.5), (w*0.38, h*0.38)],
        [(w*0.65, h*0.35), (w*0.72, h*0.22)],
        [(w*0.75, h*0.25), (w*0.82, h*0.15)],
    ]
    for sp in sub_pts:
        for i in range(len(sp)-1):
            draw_stem(draw, sp[i][0], sp[i][1], sp[i+1][0], sp[i+1][1],
                      darken(DEEP_BURGUNDY, 0.55), width=2)

    # Blossom clusters
    cluster_pts = [
        (w*0.08, h*0.42), (w*0.15, h*0.55), (w*0.25, h*0.7),
        (w*0.38, h*0.38), (w*0.45, h*0.5), (w*0.5, h*0.45),
        (w*0.55, h*0.35), (w*0.65, h*0.35), (w*0.72, h*0.22),
        (w*0.75, h*0.25), (w*0.82, h*0.15), (w*0.88, h*0.12),
        (w*0.2, h*0.6), (w*0.6, h*0.3), (w*0.35, h*0.55),
    ]
    for bx, by in cluster_pts:
        n_flowers = random.randint(4, 8)
        for _ in range(n_flowers):
            fx = bx + random.uniform(-w*0.04, w*0.04)
            fy = by + random.uniform(-h*0.04, h*0.04)
            fr = random.uniform(4, 9)
            fc = random.choice(pal[:3])
            try:
                draw.ellipse([fx-fr, fy-fr, fx+fr, fy+fr], fill=fc)
                # Petals
                for pa in range(5):
                    pangle = 360/5 * pa + random.uniform(-10, 10)
                    px = fx + math.sin(math.radians(pangle)) * fr * 1.4
                    py = fy - math.cos(math.radians(pangle)) * fr * 1.4
                    draw.ellipse([px-fr*0.6, py-fr*0.6, px+fr*0.6, py+fr*0.6],
                                fill=lighten(fc, 1.1))
            except:
                pass

    # Small leaves along branches
    for i in range(10):
        lx = w * random.uniform(0.1, 0.85)
        ly = h * random.uniform(0.15, 0.85)
        draw_leaf(draw, lx, ly, random.uniform(40, 140),
                  random.uniform(h*0.04, h*0.08),
                  random.uniform(w*0.015, w*0.025),
                  LEAF_COLORS[(seed_val+i)%len(LEAF_COLORS)])

    img = add_vignette(img, strength=0.78)
    img = add_noise(img, amount=7)
    return img


def make_gerbera(w, h, palette_idx=0, seed_val=70):
    """Bright gerbera daisy with many narrow petals and dark center."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.45

    img = radial_glow((w, h), darken(bg_color, 0.52), bg_color,
                      cx=w*0.5, cy=h*0.4, radius_factor=0.5)
    draw = ImageDraw.Draw(img)

    for _ in range(4):
        bx = random.uniform(w*0.1, w*0.9)
        by = random.uniform(h*0.1, h*0.9)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.06, w*0.14),
                          random.uniform(h*0.1, h*0.18),
                          color=darken(bg_color, 0.4))

    # Stem
    sx = cx + random.uniform(-8, 8)
    draw_stem(draw, sx, cy + min(w,h)*0.2, sx, h*0.88,
              STEM_COLORS[(seed_val)%len(STEM_COLORS)], width=2)
    for i in range(3):
        lx = sx + (-1)**i * w*0.06
        ly = h*(0.6 + i*0.08)
        draw_leaf(draw, lx, ly, 75 + i*10,
                  h*0.1, w*0.03,
                  LEAF_COLORS[(seed_val+i)%len(LEAF_COLORS)])

    # Many narrow petals
    r = min(w, h) * 0.34
    n_petals = 24
    for i in range(n_petals):
        angle = 360 / n_petals * i
        t = i / n_petals
        col = lerp(pal[0], pal[1], t * 0.5 + random.uniform(0, 0.3))
        draw_petal(draw, cx, cy, angle, r, r * 0.18, col,
                   edge_color=darken(col, 0.65), alpha=235)
    # Inner ring
    for i in range(n_petals):
        angle = 360 / n_petals * i + 7.5
        draw_petal(draw, cx, cy, angle, r*0.68, r*0.14, pal[2],
                   alpha=230)

    # Dark center with dots
    cr = min(w, h) * 0.1
    draw_center_circle(draw, cx, cy, cr, darken(pal[3], 0.5))
    for i in range(16):
        a = 2 * math.pi * i / 16
        dx = cx + math.cos(a) * cr * 0.6
        dy = cy + math.sin(a) * cr * 0.6
        try:
            draw.ellipse([dx-2, dy-2, dx+2, dy+2],
                        fill=lighten(pal[1], 1.3))
        except:
            pass

    img = add_vignette(img, strength=0.78)
    img = add_noise(img, amount=8)
    return img


# ─── Banner / Hero Background ───────────────────────────────────────────────

def make_hero_bg(w, h, seed_val=100):
    """Atmospheric hero background with botanical elements."""
    random.seed(seed_val)
    # Deep green base
    img = Image.new("RGB", (w, h), DEEP_GREEN)
    draw = ImageDraw.Draw(img)

    # Large gradient in center
    for y in range(h):
        t = 1 - abs(y - h*0.45) / (h*0.55)
        t = max(0, min(1, t))
        c = lerp(DEEP_GREEN, (28, 52, 32), t * 0.6)
        try:
            draw.line([(0, y), (w, y)], fill=c)
        except:
            pass

    # Organic background blobs
    for i in range(12):
        bx = random.uniform(w*0.0, w*1.0)
        by = random.uniform(h*0.0, h*1.0)
        brx = random.uniform(w*0.1, w*0.3)
        bry = random.uniform(h*0.15, h*0.4)
        draw_organic_blob(img, bx, by, brx, bry, n_points=random.randint(6,10),
                          color=darken(DEEP_GREEN, 0.35 + random.uniform(0, 0.15)))

    # Subtle leaf silhouettes in background
    for i in range(20):
        lx = random.uniform(0, w)
        ly = random.uniform(0, h)
        la = random.uniform(0, 360)
        ll = random.uniform(h*0.05, h*0.15)
        lw = random.uniform(w*0.015, w*0.035)
        draw_leaf(draw, lx, ly, la, ll, lw, darken(DEEP_GREEN, 0.25))

    # Large faded flower silhouettes
    for i in range(3):
        fx = w * (0.15 + i * 0.35) + random.uniform(-w*0.1, w*0.1)
        fy = h * 0.5 + random.uniform(-h*0.2, h*0.2)
        fr = min(w, h) * 0.18
        # Very faded petals
        for j in range(6):
            angle = 360/6 * j + i * 30
            rad = math.radians(angle)
            ptx = fx + math.sin(rad) * fr
            pty = fy - math.cos(rad) * fr
            pcol = darken(DEEP_GREEN, 0.3)
            try:
                draw.line([(fx, fy), (ptx, pty)], fill=pcol, width=2)
            except:
                pass

    img = add_vignette(img, strength=0.85)
    img = add_noise(img, amount=5)
    return img


def make_banner(w, h, palette_idx=1, seed_val=200):
    """Wide banner image with large flower and atmospheric background."""
    random.seed(seed_val)
    pal = FLOWER_PALETTES[palette_idx % len(FLOWER_PALETTES)]
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.35, h * 0.5

    img = radial_glow((w, h), darken(bg_color, 0.55), bg_color,
                      cx=w*0.3, cy=h*0.5, radius_factor=0.6)
    draw = ImageDraw.Draw(img)

    for _ in range(6):
        bx = random.uniform(0, w)
        by = random.uniform(0, h)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.08, w*0.2),
                          random.uniform(h*0.12, h*0.3),
                          color=darken(bg_color, 0.4))

    # Large flower
    r = min(w, h) * 0.38
    n_layers = 5
    for layer in range(n_layers):
        t = layer / n_layers
        n_petals = 8 - int(t * 3)
        angle_off = layer * 6
        pcol = lerp(pal[0], pal[2], t)
        pr = r * (1 - t * 0.75)
        for i in range(n_petals):
            angle = 360/n_petals * i + angle_off
            draw_petal(draw, cx, cy, angle, pr, pr * 0.42, pcol,
                       edge_color=darken(pcol, 0.65), alpha=230)

    draw_center_circle(draw, cx, cy, r*0.12, pal[1])
    draw_stamens(draw, cx, cy, 14, r*0.09, darken(pal[0],0.6), lighten(pal[3],1.4))

    # Background leaves
    for i in range(10):
        lx = w * random.uniform(0.05, 0.95)
        ly = h * random.uniform(0.05, 0.95)
        draw_leaf(draw, lx, ly, random.uniform(0, 360),
                  random.uniform(h*0.08, h*0.16),
                  random.uniform(w*0.02, w*0.04),
                  LEAF_COLORS[(seed_val+i)%len(LEAF_COLORS)])

    img = add_vignette(img, strength=0.82)
    img = add_noise(img, amount=7)
    return img


def make_detail_image(w, h, seed_val=300):
    """Editorial detail image — close-up botanical texture."""
    random.seed(seed_val)
    bg_color = random.choice(BG_PALETTE)
    cx, cy = w * 0.5, h * 0.5

    img = radial_glow((w, h), darken(bg_color, 0.5), bg_color,
                      cx=w*0.5, cy=h*0.5, radius_factor=0.45)
    draw = ImageDraw.Draw(img)

    for _ in range(8):
        bx = random.uniform(0, w)
        by = random.uniform(0, h)
        draw_organic_blob(img, bx, by,
                          random.uniform(w*0.1, w*0.25),
                          random.uniform(h*0.15, h*0.35),
                          color=darken(bg_color, 0.4))

    # Many overlapping petals in close-up arrangement
    pal = random.choice(FLOWER_PALETTES)
    n_flowers = 5
    positions = [(w*0.3, h*0.35), (w*0.65, h*0.3), (w*0.5, h*0.55),
                 (w*0.2, h*0.65), (w*0.75, h*0.62)]
    for fi, (fx, fy) in enumerate(positions):
        fr = min(w, h) * (0.18 + random.uniform(0, 0.08))
        fpal = FLOWER_PALETTES[(seed_val + fi) % len(FLOWER_PALETTES)]
        for layer in range(4):
            t = layer / 4
            n_petals = 6 - int(t*2)
            pcol = lerp(fpal[0], fpal[2], t)
            pr = fr * (1 - t*0.7)
            for i in range(n_petals):
                angle = 360/n_petals * i + fi*15
                draw_petal(draw, fx, fy, angle, pr, pr*0.4, pcol, alpha=230)
        draw_center_circle(draw, fx, fy, fr*0.12, fpal[1])

    img = add_vignette(img, strength=0.75)
    img = add_noise(img, amount=9)
    return img


# ─── Main ───────────────────────────────────────────────────────────────────

def get_generator(name):
    """Route filename to the appropriate generator."""
    name = name.lower()
    if "hero-bg" in name:
        return lambda w, h: make_hero_bg(w, h, seed_val=hash(name) % 1000)
    if "hero-banner" in name or "category-hero" in name:
        return lambda w, h: make_banner(w, h, palette_idx=hash(name) % 8, seed_val=hash(name) % 1000)
    if "banner" in name:
        return lambda w, h: make_banner(w, h, palette_idx=hash(name) % 8, seed_val=hash(name) % 1000)
    if "roses" in name:
        return lambda w, h: make_rose(w, h, palette_idx=3, seed_val=1)
    if "flowers-1" in name:
        return lambda w, h: make_peony(w, h, palette_idx=0, seed_val=10)
    if "flowers-2" in name:
        return lambda w, h: make_tulip(w, h, palette_idx=2, seed_val=20)
    if "flowers-3" in name:
        return lambda w, h: make_lavender(w, h, palette_idx=4, seed_val=30)
    if "flowers-5" in name:
        return lambda w, h: make_sunflower(w, h, palette_idx=5, seed_val=40)
    if "flowers-6" in name:
        return lambda w, h: make_orchid(w, h, palette_idx=4, seed_val=50)
    if "category-1" in name:
        return lambda w, h: make_peony(w, h, palette_idx=0, seed_val=10)
    if "category-2" in name:
        return lambda w, h: make_branch_blossom(w, h, palette_idx=6, seed_val=60)
    if "category-show-default" in name:
        return lambda w, h: make_banner(w, h, palette_idx=1, seed_val=200)
    if "category-default" in name:
        return lambda w, h: make_rose(w, h, palette_idx=1, seed_val=5)
    if "navbar-featured" in name:
        return lambda w, h: make_rose(w, h, palette_idx=3, seed_val=8)
    if "detail" in name:
        return lambda w, h: make_detail_image(w, h, seed_val=300 + hash(name) % 100)
    # Default
    return lambda w, h: make_rose(w, h, palette_idx=hash(name) % 8, seed_val=hash(name) % 100)


def main():
    os.makedirs(BASE, exist_ok=True)

    for rel_path, size in PATHS.items():
        w, h = size
        out_path = os.path.join(BASE, rel_path + ".jpg")
        os.makedirs(os.path.dirname(out_path), exist_ok=True)

        print(f"Generating: {rel_path}  ({w}x{h})")
        gen = get_generator(rel_path)
        img = gen(w, h)

        # Slight enhancement
        enhancer = ImageEnhance.Contrast(img)
        img = enhancer.enhance(1.08)
        enhancer = ImageEnhance.Color(img)
        img = enhancer.enhance(1.05)
        enhancer = ImageEnhance.Sharpness(img)
        img = enhancer.enhance(1.12)

        img.save(out_path, "JPEG", quality=92, optimize=True)
        print(f"  -> Saved: {out_path}")

    print("\n✅ All images generated!")


if __name__ == "__main__":
    main()
