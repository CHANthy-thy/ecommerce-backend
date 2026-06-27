(function () {
    function setPreview(imgEl, src) {
        if (!imgEl) return;
        if (!src) {
            imgEl.src = '/images/products/placeholder-100x100.png';
            return;
        }
        imgEl.src = src;
    }

    function isProbablyHttpUrl(v) {
        if (!v) return false;
        var s = String(v).trim();
        return s.startsWith('http://') || s.startsWith('https://');
    }

    document.addEventListener('DOMContentLoaded', function () {
        var imageUrlInput = document.getElementById('imageUrl');
        var previewImg = document.getElementById('imagePreview');

        if (imageUrlInput && previewImg) {
            var initialValue = imageUrlInput.value.trim();
            if (!isProbablyHttpUrl(initialValue)) {
                setPreview(previewImg, '/images/products/placeholder-100x100.png');
            } else {
                setPreview(previewImg, initialValue);
            }

            imageUrlInput.addEventListener('input', function () {
                var v = String(imageUrlInput.value || '').trim();
                if (v.length === 0 || !isProbablyHttpUrl(v)) {
                    setPreview(previewImg, '/images/products/placeholder-100x100.png');
                    return;
                }
                setPreview(previewImg, v);
            });
        }
    });
})();