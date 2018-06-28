import { post, get } from 'axios';
import { apiUrl, baseUrl } from './config';

export function saveItemID(slug, itemId) {
	return post(`${apiUrl}/packages/${slug}/envato-item-id`, { id: itemId });
}

export function updateConfig(config) {
	return post(apiUrl + '/config', { config });
}

export function testLicense(license, slug) {
	return post(`${apiUrl}/packages/${slug}/test-license`, { license });
}

export function getLicenses(limit, search) {
	return get(`${apiUrl}/licenses?limit=${limit}&search=${search}`);
};

export function addLicense(licenseData) {
	return post(`${apiUrl}/licenses/create`, licenseData);
};

export function getActivations(from, until) {
	return get(`${apiUrl}/activations?from=${from}&to=${until}`);
};

export function postLicenseAction(license_key, action) {
	return post(`${apiUrl}/licenses/${license_key}/${action}`);
};

export function addPackage(packageData) {
	return post(`${apiUrl}/packages/create`, packageData);
};

export function updatePackage(packageSlug, packageData) {
	return post(`${apiUrl}/packages/${packageSlug}/update`, packageData);
};

export function deletePackage(packageSlug) {
	return post(`${apiUrl}/packages/${packageSlug}/delete`);
};

export function getPackages() {
	return get(`${apiUrl}/packages`);
};

export function getPackage(id) {
	return get(`${apiUrl}/packages/${id}`);
};

export function getAnnouncements() {
	return get(`${apiUrl}/announcements`);
};

export function getAnnouncement(id) {
	return get(`${apiUrl}/announcements/${id}`);
};

export function postAnnouncement(announcementData) {
	return post(`${apiUrl}/announcements/create`, announcementData);
};

export function deleteAnnouncement(announcementId) {
	return post(`${apiUrl}/announcements/${announcementId}/delete`);
};