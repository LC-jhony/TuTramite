<style>
    .card {
        width: 100%;
        padding: 40px 36px;
        backdrop-filter: blur(10px);
        color: #fff;
        text-align: center;
    }

    h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .subtitle {
        font-size: 14px;
        opacity: 0.85;
        margin-bottom: 32px;
    }

    .features {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 28px;
    }

    .feature {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 18px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.12);
        text-align: left;
    }

    .icon {
        width: 22px;
        height: 22px;
        fill: none;
        stroke: white;
        stroke-width: 1.8;
        flex-shrink: 0;
        opacity: 0.9;
    }

    .feature strong {
        font-size: 14px;
        font-weight: 600;
    }

    .feature p {
        font-size: 13px;
        opacity: 0.8;
    }

    .footer {
        font-size: 12px;
        opacity: 0.65;
    }
</style>
<main class="card">
    <h1>Welcome to FilamentPHP</h1>
    <p class="subtitle">
        Your all-in-one solution for rapid application development
    </p>

    <section class="features">

        <div class="feature">
            <svg viewBox="0 0 24 24" class="icon">
                <path d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <div>
                <strong>Lightning Fast</strong>
                <p>Build powerful admin panels in minutes</p>
            </div>
        </div>

        <div class="feature">
            <svg viewBox="0 0 24 24" class="icon">
                <path d="M12 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 15a5 5 0 100-10 5 5 0 000 10z" />
            </svg>
            <div>
                <strong>Flexible & Modular</strong>
                <p>Customize every aspect with ease</p>
            </div>
        </div>

        <div class="feature">
            <svg viewBox="0 0 24 24" class="icon">
                <path
                    d="M11.049 2.927a1 1 0 011.902 0l2.036 6.26a1 1 0 00.95.69h6.588a1 1 0 01.592 1.806l-5.33 3.873a1 1 0 00-.364 1.118l2.036 6.26a1 1 0 01-1.538 1.118l-5.33-3.873a1 1 0 00-1.175 0l-5.33 3.873a1 1 0 01-1.538-1.118l2.036-6.26a1 1 0 00-.364-1.118L.883 11.683A1 1 0 011.475 9.877h6.588a1 1 0 00.95-.69l2.036-6.26z" />
            </svg>
            <div>
                <strong>Feature Rich</strong>
                <p>Advanced features built right in</p>
            </div>
        </div>

        <div class="feature">
            <svg viewBox="0 0 24 24" class="icon">
                <path d="M12 1l9 4v6c0 5.55-3.84 10.74-9 12-5.16-1.26-9-6.45-9-12V5l9-4z" />
            </svg>
            <div>
                <strong>Secure & Reliable</strong>
                <p>Built on Laravel’s solid foundation</p>
            </div>
        </div>

    </section>

    <p class="footer">
        Please log in to access your admin panel
    </p>
</main>
