import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/attributes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
export const exportXlsx = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportXlsx.url(options),
    method: 'get',
})

exportXlsx.definition = {
    methods: ["get","head"],
    url: '/cpanel/attributes/export.xlsx',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
exportXlsx.url = (options?: RouteQueryOptions) => {
    return exportXlsx.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
exportXlsx.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportXlsx.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
exportXlsx.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportXlsx.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
    const exportXlsxForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: exportXlsx.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
        exportXlsxForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportXlsx.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
        exportXlsxForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportXlsx.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    exportXlsx.form = exportXlsxForm
/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
export const importXlsxTemplate = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: importXlsxTemplate.url(options),
    method: 'get',
})

importXlsxTemplate.definition = {
    methods: ["get","head"],
    url: '/cpanel/attributes/import-template.xlsx',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
importXlsxTemplate.url = (options?: RouteQueryOptions) => {
    return importXlsxTemplate.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
importXlsxTemplate.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: importXlsxTemplate.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
importXlsxTemplate.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: importXlsxTemplate.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
    const importXlsxTemplateForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: importXlsxTemplate.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
        importXlsxTemplateForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: importXlsxTemplate.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
        importXlsxTemplateForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: importXlsxTemplate.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    importXlsxTemplate.form = importXlsxTemplateForm
const attributes = {
    index: Object.assign(index, index),
exportXlsx: Object.assign(exportXlsx, exportXlsx),
importXlsxTemplate: Object.assign(importXlsxTemplate, importXlsxTemplate),
}

export default attributes