/*
 * Tine 2.0
 * 
 * @package     Tinebase
 * @subpackage  widgets
 * @license     http://www.gnu.org/licenses/agpl.html AGPL Version 3
 * @author      Cornelius Weiss <c.weiss@metaways.de>
 * @copyright   Copyright (c) 2007-2008 Metaways Infosystems GmbH (http://www.metaways.de)
 * @version     $Id$
 *
 */
 
Ext.namespace('Tine.Tinebase.widgets.app');

Tine.Tinebase.widgets.app.GridPanel = Ext.extend(Ext.Panel, {
    /**
     * @cfg {Object} gridConfig
     * Config object for the Ext.grid.GridPanel
     */
    gridConfig: {},
    /**
     * @cfg {String} appName
     * internal/untranslated app name (required)
     */
    appName: null,
    /**
     * @cfg {String} modelName
     * name of the model/record  (required)
     */
    modelName: null,
    /**
     * @cfg {Ext.data.Record} recordClass
     * record definition class  (required)
     */
    recordClass: null,
    /**
     * @cfg {String} idProperty
     * property of the id of the record
     */
    idProperty: 'id',
    /**
     * @cfg {String} titleProperty
     * property of the title attibute, used in generic getTitle function  (required)
     */
    titleProperty: null,
    /**
     * @cfg {String} containerItemName
     * untranslated container item name
     */
    containerItemName: 'record',
    /**
     * @cfg {String} containerItemsName
     * untranslated container items (plural) name
     */
    containerItemsName: 'records',
    /**
     * @cfg {String} containerName
     * untranslated container name
     */
    containerName: 'container',
    /**
     * @cfg {string} containerName
     * untranslated name of container (plural)
     */
    containersName: 'containers',
    /**
     * @cfg {String} containerProperty
     * name of the container property
     */
    containerProperty: 'container_id',
    /**
     * @cfg {Array} actionToolbarItems
     * additional items for actionToolbar
     */
    actionToolbarItems: [],
    /**
     * @cfg {Array} contextMenuItems
     * additional items for contextMenu
     */
    contextMenuItems: [],
    /**
     * @cfg {Object} defaultSortInfo
     */
    defaultSortInfo: {},
    /**
     * @cfg {Ext.data.DataProxy} recordProxy
     */
    recordProxy: null,
    
    
    
    /**
     * @property {Ext.Tollbar} actionToolbar
     */
    actionToolbar: null,
    /**
     * @property {Ext.Menu} contextMenu
     */
    contextMenu: null,
    
    
    /**
     * @private
     */
    layout: 'fit',
    border: false,
    
    /**
     * extend standart initComponent chain
     * @private
     */
    initComponent: function(){
        // init translations
        this.i18n = new Locale.Gettext();
        this.i18n.textdomain(this.appName);
        // init actions with actionToolbar and contextMenu
        this.initActions();
        // init store
        this.initStore();
        // init (ext) grid
        this.initGrid();
        
        // tmp layout
        this.tbar = this.pagingToolbar;
        this.items = this.grid;
        
        Tine.Tinebase.widgets.app.GridPanel.superclass.initComponent.call(this);
    },
    
    /**
     * init actions with actionToolbar, contextMenu and actionUpdater
     * 
     * @private
     */
    initActions: function() {
        this.action_editInNewWindow = new Ext.Action({
            requiredGrant: 'readGrant',
            text: String.format(this.i18n._('Edit {0}'), this.containerItemName),
            disabled: true,
            actionType: 'edit',
            handler: this.onEditInNewWindow,
            iconCls: 'action_edit',
            scope: this
        });
        
        this.action_addInNewWindow= new Ext.Action({
            requiredGrant: 'addGrant',
            actionType: 'add',
            text: String.format(this.i18n._('Add {0}'), this.containerItemName),
            handler: this.onEditInNewWindow,
            iconCls: this.appName + 'IconCls',
            scope: this
        });
        
        this.action_deleteRecord = new Ext.Action({
            requiredGrant: 'deleteGrant',
            allowMultiple: true,
            singularText: String.format('Delete {0}', this.containerItemName),
            pluralText: String.format('Delete {0}', this.containerItemsName),
            translationObject: this.i18n,
            text: String.format(this.i18n.ngettext('Delete {0}', 'Delete {1}', 1), this.containerItemName, this.containerItemsName),
            handler: this.onDeleteRecords,
            disabled: true,
            iconCls: 'action_delete',
            scope: this
        });
        
        this.actions = [
            this.action_addInNewWindow,
            this.action_editInNewWindow,
            this.action_deleteRecord
        ];
        
        this.actionToolbar = new Ext.Toolbar({
            split: false,
            height: 26,
            items: this.actions.concat(this.actionToolbarItems)
        });
        
        this.contextMenu = new Ext.Menu({
            items: this.actions.concat(this.contextMenuItems)
        });
        
        // pool together all our actions, so that we can hand them over to our actionUpdater
        for (var all=this.actionToolbarItems.concat(this.contextMenuItems), i=0; i<all.length; i++) {
            if(this.actions.indexOf(all[i]) == -1) {
                this.actions.push(all[i]);
            }
        }
        
    },
    
    /**
     * init store
     * @private
     */
    initStore: function() {
        this.store = new Ext.data.Store({
            //fields: this.recordClass,
            proxy: this.recordProxy,
            remoteSort: true,
            sortInfo: this.defaultSortInfo
        });
        
        // listeners -> plugins
    },
    
    /**
     * init ext grid panel
     * @private
     */
    initGrid: function() {
        // we allways have a paging toolbar
        this.pagingToolbar = new Ext.PagingToolbar({
            pageSize: 50,
            store: this.store,
            displayInfo: true,
            displayMsg: this.i18n._('Displaying records {0} - {1} of {2}').replace(/records/, this.containerItemsName),
            emptyMsg: String.format(this.i18n._("No {0} to display"), this.containerItemsName)
        });
        
        // which grid to use?
        var Grid = this.gridConfig.quickaddMandatory ? Ext.ux.grid.QuickaddGridPanel : Ext.grid.GridPanel;
        this.grid = new Grid(this.gridConfig);
        
        // init various grid / sm listeners
        this.grid.on('keydown', this.onKeyDown, this);
        
        this.grid.on('rowclick', function(grid, row, e) {
            // only select one item as expected!
        }, this);
        
        this.grid.on('rowdblclick', function(grid, row, e){
            this.onEditInNewWindow.call(this, {actionType: 'edit'});
        }, this);
        
        this.grid.on('rowcontextmenu', function(grid, row, e) {
            e.stopEvent();
            if(!grid.getSelectionModel().isSelected(row)) {
                grid.getSelectionModel().selectRow(row);
            }
            
            this.contextMenu.showAt(e.getXY());
        }, this);
        
        this.grid.getView().addListener({
            beforerefresh: function(v) {
                v.scrollTop = v.scroller.dom.scrollTop;
            },
            refresh: function(v) {
                v.scroller.dom.scrollTop = v.scrollTop;
            }
        }, this);
        
        this.grid.getSelectionModel().on('selectionchange', function(sm) {
            Tine.widgets.ActionUpdater(sm, this.actions);
        }, this);
        
    },
    
    /**
     * key down handler
     * @private
     */
    onKeyDown: function(e){
        switch (e.getKey()) {
            case e.DELETE:
                if (!this.grid.editing) {
                    this.onDeleteRecords.call(this);
                }
                break;
            case e.RETURN:
                this.onEditInNewWindow.call(this);
                break;
        }
    },
        
    /**
     * generic edit in new window handler
     */
    onEditInNewWindow: function(btn, e) {
        
    },
    
    /**
     * generic delete handler
     */
    onDeleteRecords: function(btn, e) {
        var records = this.grid.getSelectionModel().getSelections();
        
        var i18nItems    = this.i18n.ngettext(this.containerItemName, this.containerItemsName, records.length);
        var i18nQuestion = String.format(this.i18n.ngettext('Do you really want to delete the selected {0}', 'Do you really want to delete the selected {0}', records.length), i18nItems);
            
        Ext.MessageBox.confirm(this.i18n._('Confirm'), i18nQuestion, function(btn) {
            if(btn == 'yes') {
                if (! this.deleteMask) {
                    this.deleteMask = new Ext.LoadMask(this.grid.getEl(), {msg: String.format(this.i18n._('Deleting {0}'), i18nItems)});
                }
                this.deleteMask.show();
                
                this.recordProxy.deleteRecords(records, {
                    scope: this,
                    success: function() {
                        this.deleteMask.hide();
                        this.store.load({params: this.paging});
                    },
                    failure: function () {
                        this.deleteMask.hide();
                        Ext.MessageBox.alert(this.i18n._('Failed'), String.format(this.i18n._('Could not delete {0}.'), i18nItems)); 
                    }
                });
            }
        }, this);
    }
});