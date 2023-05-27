const url = window.location.search;
const params = new URLSearchParams(url);

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

for (const [param] of params.entries())
{
    switch (param)
    {
        case 'success':
            toastr.success(escapeHtml(params.get('success')));
            break;
        case 'error':
            toastr.error(escapeHtml(params.get('error')));
            break;
    }
}