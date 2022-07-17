import { startStimulusApp } from '@symfony/stimulus-bridge';

export default class extends startStimulusApp {
    connect() {
        console.log('?');
    }
}
