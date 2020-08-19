import axios from 'axios';

axios.defaults.headers.common = {
    'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest',
    'X-CSRF-TOKEN': (document.getElementsByName('csrf-token')[0] as HTMLMetaElement)?.content || ''
};

axios.interceptors.response.use(function (response) { return response; }, function (error) {
    if (error.response.status === 401) {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }

    return Promise.reject(error);
});

export default axios;