<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Download the Tolataste Admin Console to manage your restaurant orders efficiently">
    <title>Tola Taste Africa </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-hover: #3a5dca;
            --secondary-color: #f8f9fc;
            --text-muted: #6c757d;
        }
        
        body {
            background: var(--secondary-color);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
        }
        
        .download-container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .download-card {
            max-width: 640px;
            width: 100%;
            margin: 0 auto;
            padding: 2.5rem;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            text-align: center;
            border-top: 5px solid var(--primary-color);
            transition: transform 0.3s ease;
        }
        
        .download-card:hover {
            transform: translateY(-5px);
        }
        
        .logo-img {
            width: 140px;
            height: auto;
            margin-bottom: 1.75rem;
        }
        
        .btn-download {
            margin-top: 1.75rem;
            font-size: 1.05rem;
            padding: 0.85rem 2.25rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s;
            background-color: var(--primary-color);
            border: none;
            letter-spacing: 0.5px;
        }
        
        .btn-download:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }
        
        .version-info {
            background: var(--secondary-color);
            padding: 0.85rem;
            border-radius: 10px;
            margin: 1.75rem 0;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .features-list {
            text-align: left;
            margin: 2rem 0;
            padding-left: 0;
            list-style: none;
        }
        
        .features-list li {
            margin-bottom: 0.75rem;
            padding: 0.75rem 1rem;
            background-color: rgba(78, 115, 223, 0.05);
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .features-list li:hover {
            background-color: rgba(78, 115, 223, 0.1);
            transform: translateX(5px);
        }
        
        .security-note {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }
        
        .system-requirements {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        @media (max-width: 576px) {
            .download-card {
                padding: 2rem 1.5rem;
            }
            
            .logo-img {
                width: 110px;
            }
        }
    </style>
</head>
<body>

    <div class="download-container">
        <div class="download-card">
             <a href="https://www.tolatasteofafrica.com" class="mb-3 btn btn-danger">
                <i class="bi bi-house me-2"></i> Home Page
            </a>
            <h1 class="mb-3 fw-bold" style="font-size: 1.8rem;">Tolataste Admin Console</h1>
            <!--<p class="text-muted mb-4" style="font-size: 1.05rem;">Manage restaurant orders efficiently</p>-->
          
            
            <div class="version-info">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                <div>
                    <strong>Version 1.1.0</strong> • Updated August 2025 • 
                    <span class="badge bg-success ms-2">Latest</span>
                </div>
            </div>
            
            <h3 class="h5 mb-3">Key Features:</h3>
            <ul class="features-list">
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Real-time order tracking</li>
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Update order statuses instantly</li>
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Confirm and track customer payments</li>
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Secure admin login and access</li>
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Real Time Notification</li>
            </ul>
            
         <!-- Download Button with Spinner -->
<a href="{{ asset('downloads/tolataste_admin.apk') }}" id="downloadBtn" class="btn btn-primary btn-download" download>
    <span id="downloadText"><i class="bi bi-download me-2"></i> Download Now (27.4 MB)</span>
    <span id="spinner" class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"></span>
</a>

            <div class="system-requirements">
                <i class="bi bi-phone me-1"></i> Requires Android 8.0 or later
            </div>
            
            <div class="security-note">
                <i class="bi bi-shield-check me-1"></i> <strong>Secure download</strong> • Verified and malware-free
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add animation when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.download-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
<script>
    const downloadBtn = document.getElementById('downloadBtn');
    const downloadText = document.getElementById('downloadText');
    const spinner = document.getElementById('spinner');

    downloadBtn.addEventListener('click', function () {
        // Show spinner and change text
        spinner.classList.remove('d-none');
        downloadText.innerHTML = 'Downloading...';
        downloadBtn.classList.add('disabled');

        // Simulate 3-second delay, then restore
        setTimeout(() => {
            spinner.classList.add('d-none');
            downloadText.innerHTML = '<i class="bi bi-download me-2"></i> Download Again';
            downloadBtn.classList.remove('disabled');
        }, 3000);
    });
</script>


</body>
</html>
