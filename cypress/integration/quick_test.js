/// <reference types="cypress" />

'use strict';

import { TestMethods } from '../support/test_methods.js';

describe('plugin quick test', () => {
    /**
     * Go to backend site admin if necessary
     */
    before(() => {
        TestMethods.loginIntoClientAccount();
        TestMethods.loginIntoAdminBackend();
    });

    /**
     * Run this on every test case bellow
     * - preserve cookies between tests
     */
     beforeEach(() => {
        Cypress.Cookies.defaults({
            preserve: (cookie) => {
              return true;
            }
        });
    });

    let captureMode = 'Delayed';
    let currency = Cypress.env('ENV_CURRENCY_TO_CHANGE_WITH');

    /**
     * Modify plugin settings
     */
    it('modify settings for capture mode', () => {
        TestMethods.changeCaptureMode(captureMode);
    });

    /**
     * Make a payment
     */
    it(`makes a payment with ${currency}`, () => {
        TestMethods.makePaymentFromFrontend(currency);
    });

    /**
     * Process last order from admin panel
     */
    it('process (capture/refund/void) an order from admin panel', () => {
        TestMethods.processOrderFromAdmin();
    });

}); // describe