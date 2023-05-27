const url = window.location.search;
const params = new URLSearchParams(url);

for (const [param] of params.entries())
{
    switch (param)
    {
        case 'success':
            toastr.success(params.get('success'));
            break;
        case 'error':
            toastr.error(params.get('error'));
            break;
    }
}