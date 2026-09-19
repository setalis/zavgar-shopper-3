import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
import edit055014 from './edit'
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/cpanel/products',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
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
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
export const edit = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
edit.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { product: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    product: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        product: args.product,
                }

    return edit.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
edit.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
edit.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
    const editForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
        editForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
        editForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit.form = editForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
export const variant = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: variant.url(args, options),
    method: 'get',
})

variant.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/variants/{variant}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
variant.url = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    product: args[0],
                    variant: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        product: args.product,
                                variant: args.variant,
                }

    return variant.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace('{variant}', parsedArgs.variant.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
variant.get = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: variant.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
variant.head = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: variant.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
    const variantForm = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: variant.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
        variantForm.get = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: variant.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
        variantForm.head = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: variant.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    variant.form = variantForm
/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
export const importXlsxTemplate = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: importXlsxTemplate.url(options),
    method: 'get',
})

importXlsxTemplate.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/import-template.xlsx',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
importXlsxTemplate.url = (options?: RouteQueryOptions) => {
    return importXlsxTemplate.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
importXlsxTemplate.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: importXlsxTemplate.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
importXlsxTemplate.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: importXlsxTemplate.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
    const importXlsxTemplateForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: importXlsxTemplate.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
        importXlsxTemplateForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: importXlsxTemplate.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
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
const products = {
    index: Object.assign(index, index),
edit: Object.assign(edit, edit055014),
variant: Object.assign(variant, variant),
importXlsxTemplate: Object.assign(importXlsxTemplate, importXlsxTemplate),
}

export default products