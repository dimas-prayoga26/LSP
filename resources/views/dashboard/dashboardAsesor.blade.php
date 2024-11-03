<style>
.welcome-bar {
    background-color: #2c3e50;
    color: #fff;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    margin: 20px 0;
    text-align: center;
}

.welcome-message {
    font-size: 24px;
    font-weight: 500;
    margin: 0;
    display: inline-block;
    line-height: 1.2;
    letter-spacing: 0.5px;
}

@media (max-width: 768px) {
    .welcome-message {
        font-size: 18px;
    }
}



</style>
<div class="row layout-top-spacing justify-content-center">
    <div class="col-12">
        <div class="welcome-bar text-center p-3">
            <span class="welcome-message">Selamat Datang <strong>{{ Auth::user()->name }}</strong> di LSP Politeknik Negeri Indramayu</span>
        </div>        
    </div>
</div>
</div>
