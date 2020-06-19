import axios from 'axios';

axios.defaults.headers.common = {
  'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest',
  'X-CSRF-TOKEN': (document.getElementsByName('csrf-token')[0] as HTMLMetaElement)?.content || ''
}

export default axios;