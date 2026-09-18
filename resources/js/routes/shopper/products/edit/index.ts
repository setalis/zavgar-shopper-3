import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
export const media = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: media.url(args, options),
    method: 'get',
})

media.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/media',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
media.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return media.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
media.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: media.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
media.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: media.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
    const mediaForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: media.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
        mediaForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: media.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
        mediaForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: media.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    media.form = mediaForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
export const attributes = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: attributes.url(args, options),
    method: 'get',
})

attributes.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/attributes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
attributes.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return attributes.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
attributes.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: attributes.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
attributes.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: attributes.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
    const attributesForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: attributes.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
        attributesForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: attributes.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
        attributesForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: attributes.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    attributes.form = attributesForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
export const variants = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: variants.url(args, options),
    method: 'get',
})

variants.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/variants',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
variants.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return variants.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
variants.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: variants.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
variants.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: variants.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
    const variantsForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: variants.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
        variantsForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: variants.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
        variantsForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: variants.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    variants.form = variantsForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
export const inventory = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: inventory.url(args, options),
    method: 'get',
})

inventory.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/inventory',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
inventory.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return inventory.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
inventory.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: inventory.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
inventory.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: inventory.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
    const inventoryForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: inventory.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
        inventoryForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: inventory.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
        inventoryForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: inventory.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    inventory.form = inventoryForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
export const pricing = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pricing.url(args, options),
    method: 'get',
})

pricing.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/pricing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
pricing.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return pricing.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
pricing.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pricing.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
pricing.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pricing.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
    const pricingForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: pricing.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
        pricingForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pricing.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
        pricingForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pricing.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    pricing.form = pricingForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
export const shipping = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: shipping.url(args, options),
    method: 'get',
})

shipping.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/shipping',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
shipping.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return shipping.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
shipping.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: shipping.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
shipping.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: shipping.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
    const shippingForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: shipping.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
        shippingForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: shipping.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
        shippingForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: shipping.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    shipping.form = shippingForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
export const files = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: files.url(args, options),
    method: 'get',
})

files.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/files',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
files.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return files.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
files.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: files.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
files.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: files.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
    const filesForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: files.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
        filesForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: files.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
        filesForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: files.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    files.form = filesForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
export const seo = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: seo.url(args, options),
    method: 'get',
})

seo.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/seo',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
seo.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return seo.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
seo.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: seo.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
seo.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: seo.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
    const seoForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: seo.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
        seoForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: seo.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
        seoForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: seo.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    seo.form = seoForm
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
export const related = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: related.url(args, options),
    method: 'get',
})

related.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/related',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
related.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return related.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
related.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: related.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
related.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: related.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
    const relatedForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: related.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
        relatedForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: related.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
        relatedForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: related.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    related.form = relatedForm
const edit = {
    media: Object.assign(media, media),
attributes: Object.assign(attributes, attributes),
variants: Object.assign(variants, variants),
inventory: Object.assign(inventory, inventory),
pricing: Object.assign(pricing, pricing),
shipping: Object.assign(shipping, shipping),
files: Object.assign(files, files),
seo: Object.assign(seo, seo),
related: Object.assign(related, related),
}

export default edit