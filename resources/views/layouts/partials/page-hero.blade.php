@props(['title', 'subtitle' => ''])

<div class="page-hero" id="pageHero">
    <canvas class="hero-grid-canvas" id="heroGrid"></canvas>
    <div class="hero-globe" id="heroGlobe">
        <canvas id="globeCanvas"></canvas>
    </div>
    <div class="page-hero-content">
        {!! $title !!}
        @if($subtitle)
            <p>{{ $subtitle }}</p>
        @endif
    </div>
</div>

<script>
(function() {
    // ── GRID ──
    const gridCanvas = document.getElementById('heroGrid');
    const gCtx = gridCanvas.getContext('2d');
    let gW, gH;

    function resizeGrid() {
        gW = gridCanvas.width  = gridCanvas.offsetWidth;
        gH = gridCanvas.height = gridCanvas.offsetHeight;
    }
    resizeGrid();
    window.addEventListener('resize', resizeGrid);

    function drawGrid() {
        gCtx.clearRect(0, 0, gW, gH);
        gCtx.strokeStyle = 'rgba(0,255,80,0.2)';
        gCtx.lineWidth = 0.8;

        // Globe right side pe hai to grid right center pe rakho
        const vx = gW * 0.72;
        const vy = gH * 0.62; // vanishing point — globe ke neeche
        const floorY = gH * 0.55; // floor start
        const cols = 18;
        const rows = 10;

        // Vertical lines (perspective)
        for (let i = -cols; i <= cols; i++) {
            const startX = vx + i * 38;
            gCtx.beginPath();
            gCtx.moveTo(startX, gH);
            gCtx.lineTo(vx, vy);
            gCtx.stroke();
        }

        // Horizontal lines (floor)
        for (let j = 0; j <= rows; j++) {
            const t = j / rows;
            const y = vy + (gH - vy) * t;
            const spread = t * gW * 0.75;
            gCtx.beginPath();
            gCtx.moveTo(vx - spread, y);
            gCtx.lineTo(vx + spread, y);
            gCtx.stroke();
        }

        // Dots at intersections
        gCtx.fillStyle = 'rgba(0,255,80,0.5)';
        for (let i = -cols; i <= cols; i += 2) {
            for (let j = 1; j <= rows; j += 2) {
                const t = j / rows;
                const y = vy + (gH - vy) * t;
                const spread = t * gW * 0.75;
                const lineX = vx + i * 38 * t;
                if (lineX >= vx - spread && lineX <= vx + spread) {
                    gCtx.beginPath();
                    gCtx.arc(lineX, y, 1.5, 0, Math.PI*2);
                    gCtx.fill();
                }
            }
        }
    }

    // ── GLOBE ──
    const gc = document.getElementById('globeCanvas');
    gc.width  = 240;
    gc.height = 240;
    const ctx = gc.getContext('2d');
    const cx = 120, cy = 120, R = 105;
    let rotX = 0, rotY = 0;
    let targetRX = 0, targetRY = 0;
    let mouseX = 0, mouseY = 0;

    document.getElementById('pageHero').addEventListener('mousemove', function(e) {
        const rect = this.getBoundingClientRect();
        mouseX = (e.clientX - rect.left) / rect.width  - 0.5;
        mouseY = (e.clientY - rect.top)  / rect.height - 0.5;
    });

    function project(x, y, z) {
        const cosX = Math.cos(rotX), sinX = Math.sin(rotX);
        const cosY = Math.cos(rotY), sinY = Math.sin(rotY);
        const y1 = y * cosX - z * sinX;
        const z1 = y * sinX + z * cosX;
        const x2 = x * cosY + z1 * sinY;
        return { x: cx + x2, y: cy + y1, z: -x * sinY + z1 * cosY };
    }

    function drawGlobe() {
        ctx.clearRect(0, 0, 240, 240);

        targetRX += (mouseY * 0.6 - targetRX) * 0.05;
        targetRY += (mouseX * 0.6 - targetRY) * 0.05;
        rotX = targetRX;
        rotY += 0.006;

        // Latitude lines
        for (let i = 1; i < 10; i++) {
            const phi = (i / 10) * Math.PI;
            const r2  = R * Math.sin(phi);
            const yy  = -R * Math.cos(phi);
            const pts = [];
            for (let j = 0; j <= 64; j++) {
                const theta = (j / 64) * Math.PI * 2;
                pts.push(project(r2 * Math.cos(theta), yy, r2 * Math.sin(theta)));
            }
            ctx.beginPath();
            pts.forEach((p, idx) => idx === 0 ? ctx.moveTo(p.x, p.y) : ctx.lineTo(p.x, p.y));
            ctx.closePath();
            ctx.strokeStyle = 'rgba(0,255,80,0.3)';
            ctx.lineWidth = 0.8;
            ctx.stroke();
        }

        // Longitude lines
        for (let i = 0; i < 12; i++) {
            const theta = (i / 12) * Math.PI * 2;
            const pts = [];
            for (let j = 0; j <= 64; j++) {
                const phi = (j / 64) * Math.PI;
                pts.push(project(
                    R * Math.sin(phi) * Math.cos(theta),
                    -R * Math.cos(phi),
                    R * Math.sin(phi) * Math.sin(theta)
                ));
            }
            ctx.beginPath();
            pts.forEach((p, idx) => idx === 0 ? ctx.moveTo(p.x, p.y) : ctx.lineTo(p.x, p.y));
            ctx.strokeStyle = 'rgba(0,255,80,0.3)';
            ctx.lineWidth = 0.8;
            ctx.stroke();
        }

        // Intersection dots
        for (let lat = 0; lat < 8; lat++) {
            for (let lon = 0; lon < 12; lon++) {
                const phi   = ((lat+1) / 9) * Math.PI;
                const theta = (lon / 12) * Math.PI * 2;
                const p = project(
                    R * Math.sin(phi) * Math.cos(theta),
                    -R * Math.cos(phi),
                    R * Math.sin(phi) * Math.sin(theta)
                );
                if (p.z > 0) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, 2, 0, Math.PI*2);
                    ctx.fillStyle = 'rgba(0,255,80,0.8)';
                    ctx.fill();
                }
            }
        }

        // Outer frame circle
        ctx.beginPath();
        ctx.arc(cx, cy, R, 0, Math.PI*2);
        ctx.strokeStyle = 'rgba(0,255,80,0.5)';
        ctx.lineWidth = 1.5;
        ctx.stroke();

        // White spike lines (reference pic jaisi)
        const spikes = 8;
        for (let i = 0; i < spikes; i++) {
            const angle = (i / spikes) * Math.PI * 2 + rotY;
            const x1 = cx + R * Math.cos(angle);
            const y1 = cy + R * Math.sin(angle);
            const x2 = cx + (R + 20 + Math.random()*15) * Math.cos(angle);
            const y2 = cy + (R + 20 + Math.random()*15) * Math.sin(angle);
            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.strokeStyle = 'rgba(255,255,255,0.6)';
            ctx.lineWidth = 1;
            ctx.stroke();
        }
    }

    function animate() {
        drawGrid();
        drawGlobe();
        requestAnimationFrame(animate);
    }
    animate();
})();
</script>