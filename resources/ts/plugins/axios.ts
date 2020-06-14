import axios from 'axios';

axios.defaults.headers.common = {
  'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest',
  'X-CSRFToken': (document.getElementsByName('csrf-token')[0] as HTMLInputElement).value
}

export default axios;