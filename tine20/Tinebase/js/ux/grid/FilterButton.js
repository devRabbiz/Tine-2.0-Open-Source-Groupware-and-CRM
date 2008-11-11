/*
 * Tine 2.0
 * 
 * @license     http://www.gnu.org/licenses/agpl.html AGPL Version 3
 * @author      Cornelius Weiss <c.weiss@metaways.de>
 * @copyright   Copyright (c) 2007-2008 Metaways Infosystems GmbH (http://www.metaways.de)
 * @version     $Id$
 *
 */
 
Ext.namespace('Ext.ux', 'Ext.ux.grid');

/**
 * @class Ext.ux.grid.FilterButton
 * @extends Ext.Button
 * <p>Toggle Button to be used as filter</p>
 * @constructor
 */
Ext.ux.grid.FilterButton = function(config) {
    config = config || {};
    Ext.apply(this, config);
    
    Ext.ux.grid.FilterButton.superclass.constructor.call(this);
    Ext.applyIf(this, new Ext.ux.grid.FilterPlugin());
};

Ext.extend(Ext.ux.grid.FilterButton, Ext.Button, {
    /**
     * @cfg {String} field the filed to filter
     */
    field: null,
    /**
     * @cfg {String} operator operator of filter (defualts 'equals')
     */
    operator: 'equals',
    /**
     * @cfg {Bool} invert true if loging should be inverted (defaults false)
     */
    invert: false,
    
    /**
     * @private only toggle actions make sense as filters!
     */
    enableToggle: true,
    
    /**
     * @private
     */
    getValue: function() {
        return {field: this.field, operator: this.operator, value: this.invert ? !this.pressed : this.pressed};
    },
    
    /**
     * @private
     */
    handler: function() {
        this.onFilterChange();
    }
});