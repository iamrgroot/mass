import axios, { AxiosRequestConfig, AxiosResponse } from 'axios';

axios.defaults.headers.common = {
    'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest',
    'X-CSRF-TOKEN': (document.getElementsByName('csrf-token')[0] as HTMLMetaElement)?.content || ''
};

axios.interceptors.request.use(function (request: AxiosRequestConfig): AxiosRequestConfig | Promise<AxiosRequestConfig> {
    if (request.method === 'patch' || request.method === 'put') {
        request.headers = {
            ...request.headers,
            accept: 'application/json'
        };
    }

    return request;
});

axios.interceptors.response.use(function (response: AxiosResponse): AxiosResponse<unknown> | Promise<AxiosResponse<unknown>> {
    return response;
}, function (error) {
    if (error.response.status === 401) {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }

    return Promise.reject(error);
});

export default axios;