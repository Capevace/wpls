import { post, get } from 'axios';
import { adminUrl, baseUrl } from './config';

export function saveItemID(slug, itemId) {
	return post(adminUrl + '/item/' + slug, { id: itemId });
}

export function updateConfig(config) {
	return post(adminUrl + '/config', { config });
}

export function verifyLicense(license, slug) {
	return get(`${baseUrl}/?action=verify&slug=${slug}&license_key=${license}`);
}

export function getLicenses(limit, search) {
	return get(`${adminUrl}/licenses?limit=${limit}&search=${search}`);
};

export function addLicense(licenseData) {
	return post(`${adminUrl}/license`, licenseData);
};

export function getLogs(from, until) {
	return get(`${adminUrl}/logs/${from}/${until}`);
};

export function postLicenseAction(id, action) {
	return post(`${adminUrl}/license/${id}/${action}`);
};

export function getAnnouncement(id) {
    return Promise.resolve({ 
        title: 'Some title once told me', 
        content: '# Some heading', 
    });
}