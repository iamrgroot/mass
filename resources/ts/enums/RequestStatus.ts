export enum RequestStatus {
    Request = 1,
    Approved = 2,
    Download = 3,
    Done = 4,
    Denied = 5,
    Error = 6,
}

export enum RequestStatusIcon {
    Request = '$mdiTimerSand',
    Approved = '$mdiCheck',
    Download = '$mdiDownload',
    Done = '$mdiCloudCheck',
    Denied = '$mdiClose',
    Error = '$mdiAlertCircle',
}

export enum RequestStatusName {
    Request = 'Request',
    Approved = 'Approved',
    Download = 'Downloading',
    Done = 'Done',
    Denied = 'Denied',
    Error = 'Error',
}