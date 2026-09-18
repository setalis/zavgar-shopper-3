import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/login'
 */
const LivewirePageController9b0041085e29cc730d8cb550d3e52c47 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9b0041085e29cc730d8cb550d3e52c47.url(options),
    method: 'get',
})

LivewirePageController9b0041085e29cc730d8cb550d3e52c47.definition = {
    methods: ["get","head"],
    url: '/cpanel/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/login'
 */
LivewirePageController9b0041085e29cc730d8cb550d3e52c47.url = (options?: RouteQueryOptions) => {
    return LivewirePageController9b0041085e29cc730d8cb550d3e52c47.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/login'
 */
LivewirePageController9b0041085e29cc730d8cb550d3e52c47.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9b0041085e29cc730d8cb550d3e52c47.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/login'
 */
LivewirePageController9b0041085e29cc730d8cb550d3e52c47.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController9b0041085e29cc730d8cb550d3e52c47.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/login'
 */
    const LivewirePageController9b0041085e29cc730d8cb550d3e52c47Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController9b0041085e29cc730d8cb550d3e52c47.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/login'
 */
        LivewirePageController9b0041085e29cc730d8cb550d3e52c47Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9b0041085e29cc730d8cb550d3e52c47.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/login'
 */
        LivewirePageController9b0041085e29cc730d8cb550d3e52c47Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9b0041085e29cc730d8cb550d3e52c47.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController9b0041085e29cc730d8cb550d3e52c47.form = LivewirePageController9b0041085e29cc730d8cb550d3e52c47Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset'
 */
const LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.url(options),
    method: 'get',
})

LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.definition = {
    methods: ["get","head"],
    url: '/cpanel/password/reset',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset'
 */
LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.url = (options?: RouteQueryOptions) => {
    return LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset'
 */
LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset'
 */
LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset'
 */
    const LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6aForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset'
 */
        LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6aForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset'
 */
        LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6aForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a.form = LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6aForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset/{token}'
 */
const LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1 = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.url(args, options),
    method: 'get',
})

LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.definition = {
    methods: ["get","head"],
    url: '/cpanel/password/reset/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset/{token}'
 */
LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    token: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        token: args.token,
                }

    return LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset/{token}'
 */
LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset/{token}'
 */
LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset/{token}'
 */
    const LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1Form = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset/{token}'
 */
        LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1Form.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/password/reset/{token}'
 */
        LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1Form.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1.form = LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/initialize'
 */
const LivewirePageController9ac4133ebf5c22476faa53995bad1ed0 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.url(options),
    method: 'get',
})

LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.definition = {
    methods: ["get","head"],
    url: '/cpanel/initialize',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/initialize'
 */
LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.url = (options?: RouteQueryOptions) => {
    return LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/initialize'
 */
LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/initialize'
 */
LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/initialize'
 */
    const LivewirePageController9ac4133ebf5c22476faa53995bad1ed0Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/initialize'
 */
        LivewirePageController9ac4133ebf5c22476faa53995bad1ed0Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/initialize'
 */
        LivewirePageController9ac4133ebf5c22476faa53995bad1ed0Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController9ac4133ebf5c22476faa53995bad1ed0.form = LivewirePageController9ac4133ebf5c22476faa53995bad1ed0Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/forbidden'
 */
const LivewirePageControllere6b900af09e258a385c781aec62a1e06 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllere6b900af09e258a385c781aec62a1e06.url(options),
    method: 'get',
})

LivewirePageControllere6b900af09e258a385c781aec62a1e06.definition = {
    methods: ["get","head"],
    url: '/cpanel/forbidden',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/forbidden'
 */
LivewirePageControllere6b900af09e258a385c781aec62a1e06.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllere6b900af09e258a385c781aec62a1e06.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/forbidden'
 */
LivewirePageControllere6b900af09e258a385c781aec62a1e06.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllere6b900af09e258a385c781aec62a1e06.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/forbidden'
 */
LivewirePageControllere6b900af09e258a385c781aec62a1e06.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllere6b900af09e258a385c781aec62a1e06.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/forbidden'
 */
    const LivewirePageControllere6b900af09e258a385c781aec62a1e06Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllere6b900af09e258a385c781aec62a1e06.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/forbidden'
 */
        LivewirePageControllere6b900af09e258a385c781aec62a1e06Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllere6b900af09e258a385c781aec62a1e06.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/forbidden'
 */
        LivewirePageControllere6b900af09e258a385c781aec62a1e06Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllere6b900af09e258a385c781aec62a1e06.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllere6b900af09e258a385c781aec62a1e06.form = LivewirePageControllere6b900af09e258a385c781aec62a1e06Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/dashboard'
 */
const LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.url(options),
    method: 'get',
})

LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.definition = {
    methods: ["get","head"],
    url: '/cpanel/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/dashboard'
 */
LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.url = (options?: RouteQueryOptions) => {
    return LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/dashboard'
 */
LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/dashboard'
 */
LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/dashboard'
 */
    const LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/dashboard'
 */
        LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/dashboard'
 */
        LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67.form = LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/profile'
 */
const LivewirePageControllera755758d0871b6f8cf208b1ee989fae9 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.url(options),
    method: 'get',
})

LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.definition = {
    methods: ["get","head"],
    url: '/cpanel/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/profile'
 */
LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/profile'
 */
LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/profile'
 */
LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/profile'
 */
    const LivewirePageControllera755758d0871b6f8cf208b1ee989fae9Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/profile'
 */
        LivewirePageControllera755758d0871b6f8cf208b1ee989fae9Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/profile'
 */
        LivewirePageControllera755758d0871b6f8cf208b1ee989fae9Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllera755758d0871b6f8cf208b1ee989fae9.form = LivewirePageControllera755758d0871b6f8cf208b1ee989fae9Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/general'
 */
const LivewirePageController9db14a4faa4b7ebca75929f0a81a970b = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.url(options),
    method: 'get',
})

LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/general',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/general'
 */
LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.url = (options?: RouteQueryOptions) => {
    return LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/general'
 */
LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/general'
 */
LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/general'
 */
    const LivewirePageController9db14a4faa4b7ebca75929f0a81a970bForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/general'
 */
        LivewirePageController9db14a4faa4b7ebca75929f0a81a970bForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/general'
 */
        LivewirePageController9db14a4faa4b7ebca75929f0a81a970bForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController9db14a4faa4b7ebca75929f0a81a970b.form = LivewirePageController9db14a4faa4b7ebca75929f0a81a970bForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/appearance'
 */
const LivewirePageController296c5197559ab5208102e88c18218e72 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController296c5197559ab5208102e88c18218e72.url(options),
    method: 'get',
})

LivewirePageController296c5197559ab5208102e88c18218e72.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/appearance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/appearance'
 */
LivewirePageController296c5197559ab5208102e88c18218e72.url = (options?: RouteQueryOptions) => {
    return LivewirePageController296c5197559ab5208102e88c18218e72.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/appearance'
 */
LivewirePageController296c5197559ab5208102e88c18218e72.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController296c5197559ab5208102e88c18218e72.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/appearance'
 */
LivewirePageController296c5197559ab5208102e88c18218e72.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController296c5197559ab5208102e88c18218e72.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/appearance'
 */
    const LivewirePageController296c5197559ab5208102e88c18218e72Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController296c5197559ab5208102e88c18218e72.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/appearance'
 */
        LivewirePageController296c5197559ab5208102e88c18218e72Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController296c5197559ab5208102e88c18218e72.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/appearance'
 */
        LivewirePageController296c5197559ab5208102e88c18218e72Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController296c5197559ab5208102e88c18218e72.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController296c5197559ab5208102e88c18218e72.form = LivewirePageController296c5197559ab5208102e88c18218e72Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations'
 */
const LivewirePageController6635fb945be041897598a4cdb9a45dec = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController6635fb945be041897598a4cdb9a45dec.url(options),
    method: 'get',
})

LivewirePageController6635fb945be041897598a4cdb9a45dec.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/locations',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations'
 */
LivewirePageController6635fb945be041897598a4cdb9a45dec.url = (options?: RouteQueryOptions) => {
    return LivewirePageController6635fb945be041897598a4cdb9a45dec.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations'
 */
LivewirePageController6635fb945be041897598a4cdb9a45dec.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController6635fb945be041897598a4cdb9a45dec.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations'
 */
LivewirePageController6635fb945be041897598a4cdb9a45dec.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController6635fb945be041897598a4cdb9a45dec.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations'
 */
    const LivewirePageController6635fb945be041897598a4cdb9a45decForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController6635fb945be041897598a4cdb9a45dec.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations'
 */
        LivewirePageController6635fb945be041897598a4cdb9a45decForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController6635fb945be041897598a4cdb9a45dec.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations'
 */
        LivewirePageController6635fb945be041897598a4cdb9a45decForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController6635fb945be041897598a4cdb9a45dec.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController6635fb945be041897598a4cdb9a45dec.form = LivewirePageController6635fb945be041897598a4cdb9a45decForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/create'
 */
const LivewirePageController3d615b7997387c4793b40aa61dc8a21f = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController3d615b7997387c4793b40aa61dc8a21f.url(options),
    method: 'get',
})

LivewirePageController3d615b7997387c4793b40aa61dc8a21f.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/locations/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/create'
 */
LivewirePageController3d615b7997387c4793b40aa61dc8a21f.url = (options?: RouteQueryOptions) => {
    return LivewirePageController3d615b7997387c4793b40aa61dc8a21f.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/create'
 */
LivewirePageController3d615b7997387c4793b40aa61dc8a21f.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController3d615b7997387c4793b40aa61dc8a21f.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/create'
 */
LivewirePageController3d615b7997387c4793b40aa61dc8a21f.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController3d615b7997387c4793b40aa61dc8a21f.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/create'
 */
    const LivewirePageController3d615b7997387c4793b40aa61dc8a21fForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController3d615b7997387c4793b40aa61dc8a21f.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/create'
 */
        LivewirePageController3d615b7997387c4793b40aa61dc8a21fForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController3d615b7997387c4793b40aa61dc8a21f.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/create'
 */
        LivewirePageController3d615b7997387c4793b40aa61dc8a21fForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController3d615b7997387c4793b40aa61dc8a21f.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController3d615b7997387c4793b40aa61dc8a21f.form = LivewirePageController3d615b7997387c4793b40aa61dc8a21fForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/{inventory}/edit'
 */
const LivewirePageController7e7fe047cdd940f563f0cc18680329fe = (args: { inventory: string | number } | [inventory: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController7e7fe047cdd940f563f0cc18680329fe.url(args, options),
    method: 'get',
})

LivewirePageController7e7fe047cdd940f563f0cc18680329fe.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/locations/{inventory}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/{inventory}/edit'
 */
LivewirePageController7e7fe047cdd940f563f0cc18680329fe.url = (args: { inventory: string | number } | [inventory: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { inventory: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    inventory: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        inventory: args.inventory,
                }

    return LivewirePageController7e7fe047cdd940f563f0cc18680329fe.definition.url
            .replace('{inventory}', parsedArgs.inventory.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/{inventory}/edit'
 */
LivewirePageController7e7fe047cdd940f563f0cc18680329fe.get = (args: { inventory: string | number } | [inventory: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController7e7fe047cdd940f563f0cc18680329fe.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/{inventory}/edit'
 */
LivewirePageController7e7fe047cdd940f563f0cc18680329fe.head = (args: { inventory: string | number } | [inventory: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController7e7fe047cdd940f563f0cc18680329fe.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/{inventory}/edit'
 */
    const LivewirePageController7e7fe047cdd940f563f0cc18680329feForm = (args: { inventory: string | number } | [inventory: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController7e7fe047cdd940f563f0cc18680329fe.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/{inventory}/edit'
 */
        LivewirePageController7e7fe047cdd940f563f0cc18680329feForm.get = (args: { inventory: string | number } | [inventory: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController7e7fe047cdd940f563f0cc18680329fe.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/locations/{inventory}/edit'
 */
        LivewirePageController7e7fe047cdd940f563f0cc18680329feForm.head = (args: { inventory: string | number } | [inventory: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController7e7fe047cdd940f563f0cc18680329fe.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController7e7fe047cdd940f563f0cc18680329fe.form = LivewirePageController7e7fe047cdd940f563f0cc18680329feForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/legal'
 */
const LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.url(options),
    method: 'get',
})

LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/legal',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/legal'
 */
LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.url = (options?: RouteQueryOptions) => {
    return LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/legal'
 */
LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/legal'
 */
LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/legal'
 */
    const LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/legal'
 */
        LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/legal'
 */
        LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873.form = LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/analytics'
 */
const LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.url(options),
    method: 'get',
})

LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/analytics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/analytics'
 */
LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.url = (options?: RouteQueryOptions) => {
    return LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/analytics'
 */
LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/analytics'
 */
LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/analytics'
 */
    const LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1fForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/analytics'
 */
        LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1fForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/analytics'
 */
        LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1fForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f.form = LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1fForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/channels'
 */
const LivewirePageController823e0864cbfcd8a47d2a9305e501ea89 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.url(options),
    method: 'get',
})

LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/channels',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/channels'
 */
LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.url = (options?: RouteQueryOptions) => {
    return LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/channels'
 */
LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/channels'
 */
LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/channels'
 */
    const LivewirePageController823e0864cbfcd8a47d2a9305e501ea89Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/channels'
 */
        LivewirePageController823e0864cbfcd8a47d2a9305e501ea89Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/channels'
 */
        LivewirePageController823e0864cbfcd8a47d2a9305e501ea89Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController823e0864cbfcd8a47d2a9305e501ea89.form = LivewirePageController823e0864cbfcd8a47d2a9305e501ea89Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/payment-methods'
 */
const LivewirePageControllerb4d44774dded524e0395af517023f390 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerb4d44774dded524e0395af517023f390.url(options),
    method: 'get',
})

LivewirePageControllerb4d44774dded524e0395af517023f390.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/payment-methods',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/payment-methods'
 */
LivewirePageControllerb4d44774dded524e0395af517023f390.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerb4d44774dded524e0395af517023f390.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/payment-methods'
 */
LivewirePageControllerb4d44774dded524e0395af517023f390.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerb4d44774dded524e0395af517023f390.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/payment-methods'
 */
LivewirePageControllerb4d44774dded524e0395af517023f390.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerb4d44774dded524e0395af517023f390.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/payment-methods'
 */
    const LivewirePageControllerb4d44774dded524e0395af517023f390Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerb4d44774dded524e0395af517023f390.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/payment-methods'
 */
        LivewirePageControllerb4d44774dded524e0395af517023f390Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerb4d44774dded524e0395af517023f390.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/payment-methods'
 */
        LivewirePageControllerb4d44774dded524e0395af517023f390Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerb4d44774dded524e0395af517023f390.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerb4d44774dded524e0395af517023f390.form = LivewirePageControllerb4d44774dded524e0395af517023f390Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/carriers'
 */
const LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.url(options),
    method: 'get',
})

LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/carriers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/carriers'
 */
LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/carriers'
 */
LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/carriers'
 */
LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/carriers'
 */
    const LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7ddForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/carriers'
 */
        LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7ddForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/carriers'
 */
        LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7ddForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd.form = LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7ddForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/zones'
 */
const LivewirePageController7e959f53ed6b14113fc63c70108bae64 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController7e959f53ed6b14113fc63c70108bae64.url(options),
    method: 'get',
})

LivewirePageController7e959f53ed6b14113fc63c70108bae64.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/zones',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/zones'
 */
LivewirePageController7e959f53ed6b14113fc63c70108bae64.url = (options?: RouteQueryOptions) => {
    return LivewirePageController7e959f53ed6b14113fc63c70108bae64.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/zones'
 */
LivewirePageController7e959f53ed6b14113fc63c70108bae64.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController7e959f53ed6b14113fc63c70108bae64.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/zones'
 */
LivewirePageController7e959f53ed6b14113fc63c70108bae64.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController7e959f53ed6b14113fc63c70108bae64.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/zones'
 */
    const LivewirePageController7e959f53ed6b14113fc63c70108bae64Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController7e959f53ed6b14113fc63c70108bae64.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/zones'
 */
        LivewirePageController7e959f53ed6b14113fc63c70108bae64Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController7e959f53ed6b14113fc63c70108bae64.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/zones'
 */
        LivewirePageController7e959f53ed6b14113fc63c70108bae64Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController7e959f53ed6b14113fc63c70108bae64.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController7e959f53ed6b14113fc63c70108bae64.form = LivewirePageController7e959f53ed6b14113fc63c70108bae64Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/taxes'
 */
const LivewirePageController07816d54f01a66865f01c8c187457ead = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController07816d54f01a66865f01c8c187457ead.url(options),
    method: 'get',
})

LivewirePageController07816d54f01a66865f01c8c187457ead.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/taxes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/taxes'
 */
LivewirePageController07816d54f01a66865f01c8c187457ead.url = (options?: RouteQueryOptions) => {
    return LivewirePageController07816d54f01a66865f01c8c187457ead.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/taxes'
 */
LivewirePageController07816d54f01a66865f01c8c187457ead.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController07816d54f01a66865f01c8c187457ead.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/taxes'
 */
LivewirePageController07816d54f01a66865f01c8c187457ead.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController07816d54f01a66865f01c8c187457ead.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/taxes'
 */
    const LivewirePageController07816d54f01a66865f01c8c187457eadForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController07816d54f01a66865f01c8c187457ead.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/taxes'
 */
        LivewirePageController07816d54f01a66865f01c8c187457eadForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController07816d54f01a66865f01c8c187457ead.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/taxes'
 */
        LivewirePageController07816d54f01a66865f01c8c187457eadForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController07816d54f01a66865f01c8c187457ead.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController07816d54f01a66865f01c8c187457ead.form = LivewirePageController07816d54f01a66865f01c8c187457eadForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/currencies'
 */
const LivewirePageController6df012a1b428c06ed35ec613d67a9e00 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController6df012a1b428c06ed35ec613d67a9e00.url(options),
    method: 'get',
})

LivewirePageController6df012a1b428c06ed35ec613d67a9e00.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/currencies',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/currencies'
 */
LivewirePageController6df012a1b428c06ed35ec613d67a9e00.url = (options?: RouteQueryOptions) => {
    return LivewirePageController6df012a1b428c06ed35ec613d67a9e00.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/currencies'
 */
LivewirePageController6df012a1b428c06ed35ec613d67a9e00.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController6df012a1b428c06ed35ec613d67a9e00.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/currencies'
 */
LivewirePageController6df012a1b428c06ed35ec613d67a9e00.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController6df012a1b428c06ed35ec613d67a9e00.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/currencies'
 */
    const LivewirePageController6df012a1b428c06ed35ec613d67a9e00Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController6df012a1b428c06ed35ec613d67a9e00.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/currencies'
 */
        LivewirePageController6df012a1b428c06ed35ec613d67a9e00Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController6df012a1b428c06ed35ec613d67a9e00.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/currencies'
 */
        LivewirePageController6df012a1b428c06ed35ec613d67a9e00Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController6df012a1b428c06ed35ec613d67a9e00.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController6df012a1b428c06ed35ec613d67a9e00.form = LivewirePageController6df012a1b428c06ed35ec613d67a9e00Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/webhooks'
 */
const LivewirePageControllerec2a7ba0a02cc00223755365f1eec503 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.url(options),
    method: 'get',
})

LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/webhooks',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/webhooks'
 */
LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/webhooks'
 */
LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/webhooks'
 */
LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/webhooks'
 */
    const LivewirePageControllerec2a7ba0a02cc00223755365f1eec503Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/webhooks'
 */
        LivewirePageControllerec2a7ba0a02cc00223755365f1eec503Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/webhooks'
 */
        LivewirePageControllerec2a7ba0a02cc00223755365f1eec503Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerec2a7ba0a02cc00223755365f1eec503.form = LivewirePageControllerec2a7ba0a02cc00223755365f1eec503Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team'
 */
const LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.url(options),
    method: 'get',
})

LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/team',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team'
 */
LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.url = (options?: RouteQueryOptions) => {
    return LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team'
 */
LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team'
 */
LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team'
 */
    const LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team'
 */
        LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team'
 */
        LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866.form = LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team/roles/{role}'
 */
const LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35 = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.url(args, options),
    method: 'get',
})

LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.definition = {
    methods: ["get","head"],
    url: '/cpanel/setting/team/roles/{role}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team/roles/{role}'
 */
LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.url = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { role: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    role: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        role: args.role,
                }

    return LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.definition.url
            .replace('{role}', parsedArgs.role.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team/roles/{role}'
 */
LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.get = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team/roles/{role}'
 */
LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.head = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team/roles/{role}'
 */
    const LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35Form = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team/roles/{role}'
 */
        LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35Form.get = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/setting/team/roles/{role}'
 */
        LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35Form.head = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35.form = LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers'
 */
const LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.url(options),
    method: 'get',
})

LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.definition = {
    methods: ["get","head"],
    url: '/cpanel/customers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers'
 */
LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.url = (options?: RouteQueryOptions) => {
    return LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers'
 */
LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers'
 */
LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers'
 */
    const LivewirePageController35dc1275b388029f00d9bcdd0b5adb7eForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers'
 */
        LivewirePageController35dc1275b388029f00d9bcdd0b5adb7eForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers'
 */
        LivewirePageController35dc1275b388029f00d9bcdd0b5adb7eForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e.form = LivewirePageController35dc1275b388029f00d9bcdd0b5adb7eForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/create'
 */
const LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.url(options),
    method: 'get',
})

LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.definition = {
    methods: ["get","head"],
    url: '/cpanel/customers/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/create'
 */
LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.url = (options?: RouteQueryOptions) => {
    return LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/create'
 */
LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/create'
 */
LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/create'
 */
    const LivewirePageController64868e66e2cbba7c34514ea3ee7bf8feForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/create'
 */
        LivewirePageController64868e66e2cbba7c34514ea3ee7bf8feForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/create'
 */
        LivewirePageController64868e66e2cbba7c34514ea3ee7bf8feForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe.form = LivewirePageController64868e66e2cbba7c34514ea3ee7bf8feForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/{user}/show'
 */
const LivewirePageController9dfa2002759f4096a239f95bf6c2b46d = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.url(args, options),
    method: 'get',
})

LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.definition = {
    methods: ["get","head"],
    url: '/cpanel/customers/{user}/show',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/{user}/show'
 */
LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.url = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    user: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        user: args.user,
                }

    return LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/{user}/show'
 */
LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.get = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/{user}/show'
 */
LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.head = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/{user}/show'
 */
    const LivewirePageController9dfa2002759f4096a239f95bf6c2b46dForm = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/{user}/show'
 */
        LivewirePageController9dfa2002759f4096a239f95bf6c2b46dForm.get = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/customers/{user}/show'
 */
        LivewirePageController9dfa2002759f4096a239f95bf6c2b46dForm.head = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController9dfa2002759f4096a239f95bf6c2b46d.form = LivewirePageController9dfa2002759f4096a239f95bf6c2b46dForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders'
 */
const LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.url(options),
    method: 'get',
})

LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.definition = {
    methods: ["get","head"],
    url: '/cpanel/orders',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders'
 */
LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.url = (options?: RouteQueryOptions) => {
    return LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders'
 */
LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders'
 */
LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders'
 */
    const LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4ebForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders'
 */
        LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4ebForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders'
 */
        LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4ebForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb.form = LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4ebForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/shipments'
 */
const LivewirePageController367b78de9753c6055b68823aa54fcb3b = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController367b78de9753c6055b68823aa54fcb3b.url(options),
    method: 'get',
})

LivewirePageController367b78de9753c6055b68823aa54fcb3b.definition = {
    methods: ["get","head"],
    url: '/cpanel/orders/shipments',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/shipments'
 */
LivewirePageController367b78de9753c6055b68823aa54fcb3b.url = (options?: RouteQueryOptions) => {
    return LivewirePageController367b78de9753c6055b68823aa54fcb3b.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/shipments'
 */
LivewirePageController367b78de9753c6055b68823aa54fcb3b.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController367b78de9753c6055b68823aa54fcb3b.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/shipments'
 */
LivewirePageController367b78de9753c6055b68823aa54fcb3b.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController367b78de9753c6055b68823aa54fcb3b.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/shipments'
 */
    const LivewirePageController367b78de9753c6055b68823aa54fcb3bForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController367b78de9753c6055b68823aa54fcb3b.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/shipments'
 */
        LivewirePageController367b78de9753c6055b68823aa54fcb3bForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController367b78de9753c6055b68823aa54fcb3b.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/shipments'
 */
        LivewirePageController367b78de9753c6055b68823aa54fcb3bForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController367b78de9753c6055b68823aa54fcb3b.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController367b78de9753c6055b68823aa54fcb3b.form = LivewirePageController367b78de9753c6055b68823aa54fcb3bForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/abandoned-carts'
 */
const LivewirePageController39e8e91f2eb96dfc808648887f45f682 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController39e8e91f2eb96dfc808648887f45f682.url(options),
    method: 'get',
})

LivewirePageController39e8e91f2eb96dfc808648887f45f682.definition = {
    methods: ["get","head"],
    url: '/cpanel/orders/abandoned-carts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/abandoned-carts'
 */
LivewirePageController39e8e91f2eb96dfc808648887f45f682.url = (options?: RouteQueryOptions) => {
    return LivewirePageController39e8e91f2eb96dfc808648887f45f682.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/abandoned-carts'
 */
LivewirePageController39e8e91f2eb96dfc808648887f45f682.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController39e8e91f2eb96dfc808648887f45f682.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/abandoned-carts'
 */
LivewirePageController39e8e91f2eb96dfc808648887f45f682.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController39e8e91f2eb96dfc808648887f45f682.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/abandoned-carts'
 */
    const LivewirePageController39e8e91f2eb96dfc808648887f45f682Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController39e8e91f2eb96dfc808648887f45f682.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/abandoned-carts'
 */
        LivewirePageController39e8e91f2eb96dfc808648887f45f682Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController39e8e91f2eb96dfc808648887f45f682.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/abandoned-carts'
 */
        LivewirePageController39e8e91f2eb96dfc808648887f45f682Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController39e8e91f2eb96dfc808648887f45f682.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController39e8e91f2eb96dfc808648887f45f682.form = LivewirePageController39e8e91f2eb96dfc808648887f45f682Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/{order}/detail'
 */
const LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155 = (args: { order: string | number } | [order: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.url(args, options),
    method: 'get',
})

LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.definition = {
    methods: ["get","head"],
    url: '/cpanel/orders/{order}/detail',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/{order}/detail'
 */
LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.url = (args: { order: string | number } | [order: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { order: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    order: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        order: args.order,
                }

    return LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.definition.url
            .replace('{order}', parsedArgs.order.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/{order}/detail'
 */
LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.get = (args: { order: string | number } | [order: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/{order}/detail'
 */
LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.head = (args: { order: string | number } | [order: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/{order}/detail'
 */
    const LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155Form = (args: { order: string | number } | [order: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/{order}/detail'
 */
        LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155Form.get = (args: { order: string | number } | [order: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/orders/{order}/detail'
 */
        LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155Form.head = (args: { order: string | number } | [order: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155.form = LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
const LivewirePageControllerba4d971e38b1bc5188b75723ffae2538 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.url(options),
    method: 'get',
})

LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.definition = {
    methods: ["get","head"],
    url: '/cpanel/products',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
    const LivewirePageControllerba4d971e38b1bc5188b75723ffae2538Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
        LivewirePageControllerba4d971e38b1bc5188b75723ffae2538Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products'
 */
        LivewirePageControllerba4d971e38b1bc5188b75723ffae2538Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerba4d971e38b1bc5188b75723ffae2538.form = LivewirePageControllerba4d971e38b1bc5188b75723ffae2538Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
const LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.url(args, options),
    method: 'get',
})

LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
    const LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
        LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit'
 */
        LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17.form = LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
const LivewirePageControllera20b2461df92e11600f6f3759b9786e5 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera20b2461df92e11600f6f3759b9786e5.url(args, options),
    method: 'get',
})

LivewirePageControllera20b2461df92e11600f6f3759b9786e5.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/media',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
LivewirePageControllera20b2461df92e11600f6f3759b9786e5.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageControllera20b2461df92e11600f6f3759b9786e5.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
LivewirePageControllera20b2461df92e11600f6f3759b9786e5.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera20b2461df92e11600f6f3759b9786e5.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
LivewirePageControllera20b2461df92e11600f6f3759b9786e5.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllera20b2461df92e11600f6f3759b9786e5.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
    const LivewirePageControllera20b2461df92e11600f6f3759b9786e5Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllera20b2461df92e11600f6f3759b9786e5.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
        LivewirePageControllera20b2461df92e11600f6f3759b9786e5Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera20b2461df92e11600f6f3759b9786e5.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/media'
 */
        LivewirePageControllera20b2461df92e11600f6f3759b9786e5Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera20b2461df92e11600f6f3759b9786e5.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllera20b2461df92e11600f6f3759b9786e5.form = LivewirePageControllera20b2461df92e11600f6f3759b9786e5Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
const LivewirePageController328699919ee949a22542508bf550d289 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController328699919ee949a22542508bf550d289.url(args, options),
    method: 'get',
})

LivewirePageController328699919ee949a22542508bf550d289.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/attributes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
LivewirePageController328699919ee949a22542508bf550d289.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageController328699919ee949a22542508bf550d289.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
LivewirePageController328699919ee949a22542508bf550d289.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController328699919ee949a22542508bf550d289.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
LivewirePageController328699919ee949a22542508bf550d289.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController328699919ee949a22542508bf550d289.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
    const LivewirePageController328699919ee949a22542508bf550d289Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController328699919ee949a22542508bf550d289.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
        LivewirePageController328699919ee949a22542508bf550d289Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController328699919ee949a22542508bf550d289.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/attributes'
 */
        LivewirePageController328699919ee949a22542508bf550d289Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController328699919ee949a22542508bf550d289.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController328699919ee949a22542508bf550d289.form = LivewirePageController328699919ee949a22542508bf550d289Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
const LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.url(args, options),
    method: 'get',
})

LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/variants',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
    const LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
        LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants'
 */
        LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6.form = LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
const LivewirePageControllerbeb96d2b1846075729e6a163c643920a = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerbeb96d2b1846075729e6a163c643920a.url(args, options),
    method: 'get',
})

LivewirePageControllerbeb96d2b1846075729e6a163c643920a.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/variants/{variant}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
LivewirePageControllerbeb96d2b1846075729e6a163c643920a.url = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions) => {
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

    return LivewirePageControllerbeb96d2b1846075729e6a163c643920a.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace('{variant}', parsedArgs.variant.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
LivewirePageControllerbeb96d2b1846075729e6a163c643920a.get = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerbeb96d2b1846075729e6a163c643920a.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
LivewirePageControllerbeb96d2b1846075729e6a163c643920a.head = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerbeb96d2b1846075729e6a163c643920a.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
    const LivewirePageControllerbeb96d2b1846075729e6a163c643920aForm = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerbeb96d2b1846075729e6a163c643920a.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
        LivewirePageControllerbeb96d2b1846075729e6a163c643920aForm.get = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerbeb96d2b1846075729e6a163c643920a.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/variants/{variant}'
 */
        LivewirePageControllerbeb96d2b1846075729e6a163c643920aForm.head = (args: { product: string | number, variant: string | number } | [product: string | number, variant: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerbeb96d2b1846075729e6a163c643920a.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerbeb96d2b1846075729e6a163c643920a.form = LivewirePageControllerbeb96d2b1846075729e6a163c643920aForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
const LivewirePageController29243b7ae44dd8d6833d1a431169330f = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController29243b7ae44dd8d6833d1a431169330f.url(args, options),
    method: 'get',
})

LivewirePageController29243b7ae44dd8d6833d1a431169330f.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/inventory',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
LivewirePageController29243b7ae44dd8d6833d1a431169330f.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageController29243b7ae44dd8d6833d1a431169330f.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
LivewirePageController29243b7ae44dd8d6833d1a431169330f.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController29243b7ae44dd8d6833d1a431169330f.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
LivewirePageController29243b7ae44dd8d6833d1a431169330f.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController29243b7ae44dd8d6833d1a431169330f.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
    const LivewirePageController29243b7ae44dd8d6833d1a431169330fForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController29243b7ae44dd8d6833d1a431169330f.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
        LivewirePageController29243b7ae44dd8d6833d1a431169330fForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController29243b7ae44dd8d6833d1a431169330f.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/inventory'
 */
        LivewirePageController29243b7ae44dd8d6833d1a431169330fForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController29243b7ae44dd8d6833d1a431169330f.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController29243b7ae44dd8d6833d1a431169330f.form = LivewirePageController29243b7ae44dd8d6833d1a431169330fForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
const LivewirePageController957a1147a3dc2c9abe3fd4955c991870 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController957a1147a3dc2c9abe3fd4955c991870.url(args, options),
    method: 'get',
})

LivewirePageController957a1147a3dc2c9abe3fd4955c991870.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/pricing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
LivewirePageController957a1147a3dc2c9abe3fd4955c991870.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageController957a1147a3dc2c9abe3fd4955c991870.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
LivewirePageController957a1147a3dc2c9abe3fd4955c991870.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController957a1147a3dc2c9abe3fd4955c991870.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
LivewirePageController957a1147a3dc2c9abe3fd4955c991870.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController957a1147a3dc2c9abe3fd4955c991870.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
    const LivewirePageController957a1147a3dc2c9abe3fd4955c991870Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController957a1147a3dc2c9abe3fd4955c991870.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
        LivewirePageController957a1147a3dc2c9abe3fd4955c991870Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController957a1147a3dc2c9abe3fd4955c991870.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/pricing'
 */
        LivewirePageController957a1147a3dc2c9abe3fd4955c991870Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController957a1147a3dc2c9abe3fd4955c991870.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController957a1147a3dc2c9abe3fd4955c991870.form = LivewirePageController957a1147a3dc2c9abe3fd4955c991870Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
const LivewirePageController1376ec20baaa13f484c5b81fee47e102 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController1376ec20baaa13f484c5b81fee47e102.url(args, options),
    method: 'get',
})

LivewirePageController1376ec20baaa13f484c5b81fee47e102.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/shipping',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
LivewirePageController1376ec20baaa13f484c5b81fee47e102.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageController1376ec20baaa13f484c5b81fee47e102.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
LivewirePageController1376ec20baaa13f484c5b81fee47e102.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController1376ec20baaa13f484c5b81fee47e102.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
LivewirePageController1376ec20baaa13f484c5b81fee47e102.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController1376ec20baaa13f484c5b81fee47e102.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
    const LivewirePageController1376ec20baaa13f484c5b81fee47e102Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController1376ec20baaa13f484c5b81fee47e102.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
        LivewirePageController1376ec20baaa13f484c5b81fee47e102Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController1376ec20baaa13f484c5b81fee47e102.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/shipping'
 */
        LivewirePageController1376ec20baaa13f484c5b81fee47e102Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController1376ec20baaa13f484c5b81fee47e102.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController1376ec20baaa13f484c5b81fee47e102.form = LivewirePageController1376ec20baaa13f484c5b81fee47e102Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
const LivewirePageController70af48a542748564b1f8eb1cc4bf3814 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController70af48a542748564b1f8eb1cc4bf3814.url(args, options),
    method: 'get',
})

LivewirePageController70af48a542748564b1f8eb1cc4bf3814.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/files',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
LivewirePageController70af48a542748564b1f8eb1cc4bf3814.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageController70af48a542748564b1f8eb1cc4bf3814.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
LivewirePageController70af48a542748564b1f8eb1cc4bf3814.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController70af48a542748564b1f8eb1cc4bf3814.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
LivewirePageController70af48a542748564b1f8eb1cc4bf3814.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController70af48a542748564b1f8eb1cc4bf3814.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
    const LivewirePageController70af48a542748564b1f8eb1cc4bf3814Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController70af48a542748564b1f8eb1cc4bf3814.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
        LivewirePageController70af48a542748564b1f8eb1cc4bf3814Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController70af48a542748564b1f8eb1cc4bf3814.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/files'
 */
        LivewirePageController70af48a542748564b1f8eb1cc4bf3814Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController70af48a542748564b1f8eb1cc4bf3814.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController70af48a542748564b1f8eb1cc4bf3814.form = LivewirePageController70af48a542748564b1f8eb1cc4bf3814Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
const LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9 = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.url(args, options),
    method: 'get',
})

LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/seo',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
    const LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9Form = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
        LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9Form.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/seo'
 */
        LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9Form.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9.form = LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
const LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.url(args, options),
    method: 'get',
})

LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/related',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
    const LivewirePageControllera7c01121055dd6961e9d3a6038b55c6aForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
        LivewirePageControllera7c01121055dd6961e9d3a6038b55c6aForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/{product}/edit/related'
 */
        LivewirePageControllera7c01121055dd6961e9d3a6038b55c6aForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a.form = LivewirePageControllera7c01121055dd6961e9d3a6038b55c6aForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
const LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.url(options),
    method: 'get',
})

LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/attributes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
    const LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
        LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/attributes'
 */
        LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707.form = LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/tags'
 */
const LivewirePageController03975106eeb6cf71e849fa2896abd9f1 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController03975106eeb6cf71e849fa2896abd9f1.url(options),
    method: 'get',
})

LivewirePageController03975106eeb6cf71e849fa2896abd9f1.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/tags',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/tags'
 */
LivewirePageController03975106eeb6cf71e849fa2896abd9f1.url = (options?: RouteQueryOptions) => {
    return LivewirePageController03975106eeb6cf71e849fa2896abd9f1.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/tags'
 */
LivewirePageController03975106eeb6cf71e849fa2896abd9f1.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController03975106eeb6cf71e849fa2896abd9f1.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/tags'
 */
LivewirePageController03975106eeb6cf71e849fa2896abd9f1.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController03975106eeb6cf71e849fa2896abd9f1.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/tags'
 */
    const LivewirePageController03975106eeb6cf71e849fa2896abd9f1Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController03975106eeb6cf71e849fa2896abd9f1.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/tags'
 */
        LivewirePageController03975106eeb6cf71e849fa2896abd9f1Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController03975106eeb6cf71e849fa2896abd9f1.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/products/tags'
 */
        LivewirePageController03975106eeb6cf71e849fa2896abd9f1Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController03975106eeb6cf71e849fa2896abd9f1.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController03975106eeb6cf71e849fa2896abd9f1.form = LivewirePageController03975106eeb6cf71e849fa2896abd9f1Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/brands'
 */
const LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.url(options),
    method: 'get',
})

LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.definition = {
    methods: ["get","head"],
    url: '/cpanel/brands',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/brands'
 */
LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/brands'
 */
LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/brands'
 */
LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/brands'
 */
    const LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fdForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/brands'
 */
        LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fdForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/brands'
 */
        LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fdForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd.form = LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fdForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
const LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.url(options),
    method: 'get',
})

LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.definition = {
    methods: ["get","head"],
    url: '/cpanel/categories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.url = (options?: RouteQueryOptions) => {
    return LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
    const LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
        LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
        LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5.form = LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections'
 */
const LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.url(options),
    method: 'get',
})

LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.definition = {
    methods: ["get","head"],
    url: '/cpanel/collections',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections'
 */
LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections'
 */
LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections'
 */
LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections'
 */
    const LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections'
 */
        LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections'
 */
        LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798.form = LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections/{collection}/edit'
 */
const LivewirePageControlleraea69969336694e302a786d7a17a991f = (args: { collection: string | number } | [collection: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControlleraea69969336694e302a786d7a17a991f.url(args, options),
    method: 'get',
})

LivewirePageControlleraea69969336694e302a786d7a17a991f.definition = {
    methods: ["get","head"],
    url: '/cpanel/collections/{collection}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections/{collection}/edit'
 */
LivewirePageControlleraea69969336694e302a786d7a17a991f.url = (args: { collection: string | number } | [collection: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { collection: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    collection: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        collection: args.collection,
                }

    return LivewirePageControlleraea69969336694e302a786d7a17a991f.definition.url
            .replace('{collection}', parsedArgs.collection.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections/{collection}/edit'
 */
LivewirePageControlleraea69969336694e302a786d7a17a991f.get = (args: { collection: string | number } | [collection: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControlleraea69969336694e302a786d7a17a991f.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections/{collection}/edit'
 */
LivewirePageControlleraea69969336694e302a786d7a17a991f.head = (args: { collection: string | number } | [collection: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControlleraea69969336694e302a786d7a17a991f.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections/{collection}/edit'
 */
    const LivewirePageControlleraea69969336694e302a786d7a17a991fForm = (args: { collection: string | number } | [collection: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControlleraea69969336694e302a786d7a17a991f.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections/{collection}/edit'
 */
        LivewirePageControlleraea69969336694e302a786d7a17a991fForm.get = (args: { collection: string | number } | [collection: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControlleraea69969336694e302a786d7a17a991f.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/collections/{collection}/edit'
 */
        LivewirePageControlleraea69969336694e302a786d7a17a991fForm.head = (args: { collection: string | number } | [collection: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControlleraea69969336694e302a786d7a17a991f.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControlleraea69969336694e302a786d7a17a991f.form = LivewirePageControlleraea69969336694e302a786d7a17a991fForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns'
 */
const LivewirePageController25df21ef6c8202b526cacdd2b9da8d46 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.url(options),
    method: 'get',
})

LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.definition = {
    methods: ["get","head"],
    url: '/cpanel/campaigns',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns'
 */
LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.url = (options?: RouteQueryOptions) => {
    return LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns'
 */
LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns'
 */
LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns'
 */
    const LivewirePageController25df21ef6c8202b526cacdd2b9da8d46Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns'
 */
        LivewirePageController25df21ef6c8202b526cacdd2b9da8d46Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns'
 */
        LivewirePageController25df21ef6c8202b526cacdd2b9da8d46Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController25df21ef6c8202b526cacdd2b9da8d46.form = LivewirePageController25df21ef6c8202b526cacdd2b9da8d46Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/create'
 */
const LivewirePageController468ce0be8dd63c471212fc8a6aed72d2 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.url(options),
    method: 'get',
})

LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.definition = {
    methods: ["get","head"],
    url: '/cpanel/campaigns/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/create'
 */
LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.url = (options?: RouteQueryOptions) => {
    return LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/create'
 */
LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/create'
 */
LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/create'
 */
    const LivewirePageController468ce0be8dd63c471212fc8a6aed72d2Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/create'
 */
        LivewirePageController468ce0be8dd63c471212fc8a6aed72d2Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/create'
 */
        LivewirePageController468ce0be8dd63c471212fc8a6aed72d2Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController468ce0be8dd63c471212fc8a6aed72d2.form = LivewirePageController468ce0be8dd63c471212fc8a6aed72d2Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/{record}/edit'
 */
const LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9 = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.url(args, options),
    method: 'get',
})

LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.definition = {
    methods: ["get","head"],
    url: '/cpanel/campaigns/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/{record}/edit'
 */
LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    record: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        record: args.record,
                }

    return LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/{record}/edit'
 */
LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/{record}/edit'
 */
LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/{record}/edit'
 */
    const LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9Form = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/{record}/edit'
 */
        LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9Form.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/campaigns/{record}/edit'
 */
        LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9Form.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9.form = LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts'
 */
const LivewirePageControllerc43f397c18348b40c410c4ad490336c1 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerc43f397c18348b40c410c4ad490336c1.url(options),
    method: 'get',
})

LivewirePageControllerc43f397c18348b40c410c4ad490336c1.definition = {
    methods: ["get","head"],
    url: '/cpanel/discounts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts'
 */
LivewirePageControllerc43f397c18348b40c410c4ad490336c1.url = (options?: RouteQueryOptions) => {
    return LivewirePageControllerc43f397c18348b40c410c4ad490336c1.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts'
 */
LivewirePageControllerc43f397c18348b40c410c4ad490336c1.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllerc43f397c18348b40c410c4ad490336c1.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts'
 */
LivewirePageControllerc43f397c18348b40c410c4ad490336c1.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllerc43f397c18348b40c410c4ad490336c1.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts'
 */
    const LivewirePageControllerc43f397c18348b40c410c4ad490336c1Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllerc43f397c18348b40c410c4ad490336c1.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts'
 */
        LivewirePageControllerc43f397c18348b40c410c4ad490336c1Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerc43f397c18348b40c410c4ad490336c1.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts'
 */
        LivewirePageControllerc43f397c18348b40c410c4ad490336c1Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllerc43f397c18348b40c410c4ad490336c1.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllerc43f397c18348b40c410c4ad490336c1.form = LivewirePageControllerc43f397c18348b40c410c4ad490336c1Form
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts/{record}/edit'
 */
const LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.url(args, options),
    method: 'get',
})

LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.definition = {
    methods: ["get","head"],
    url: '/cpanel/discounts/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts/{record}/edit'
 */
LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    record: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        record: args.record,
                }

    return LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts/{record}/edit'
 */
LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.url(args, options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts/{record}/edit'
 */
LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.url(args, options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts/{record}/edit'
 */
    const LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844fForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.url(args, options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts/{record}/edit'
 */
        LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844fForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.url(args, options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/discounts/{record}/edit'
 */
        LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844fForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f.form = LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844fForm
    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/reviews'
 */
const LivewirePageController9ff15722299988959e0c18911d680164 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9ff15722299988959e0c18911d680164.url(options),
    method: 'get',
})

LivewirePageController9ff15722299988959e0c18911d680164.definition = {
    methods: ["get","head"],
    url: '/cpanel/reviews',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/reviews'
 */
LivewirePageController9ff15722299988959e0c18911d680164.url = (options?: RouteQueryOptions) => {
    return LivewirePageController9ff15722299988959e0c18911d680164.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/reviews'
 */
LivewirePageController9ff15722299988959e0c18911d680164.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LivewirePageController9ff15722299988959e0c18911d680164.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/reviews'
 */
LivewirePageController9ff15722299988959e0c18911d680164.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LivewirePageController9ff15722299988959e0c18911d680164.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/reviews'
 */
    const LivewirePageController9ff15722299988959e0c18911d680164Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: LivewirePageController9ff15722299988959e0c18911d680164.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/reviews'
 */
        LivewirePageController9ff15722299988959e0c18911d680164Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9ff15722299988959e0c18911d680164.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/reviews'
 */
        LivewirePageController9ff15722299988959e0c18911d680164Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: LivewirePageController9ff15722299988959e0c18911d680164.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    LivewirePageController9ff15722299988959e0c18911d680164.form = LivewirePageController9ff15722299988959e0c18911d680164Form

/**
* Multiple routes resolve to \Livewire\Mechanisms\HandleRouting\LivewirePageController::LivewirePageController, so this export is a
* dictionary keyed by URI rather than a callable. Call a specific route with `LivewirePageController['<uri>'](...)`,
* or import the route by name from your generated `routes/` directory.
*/
const LivewirePageController = {
    '/cpanel/login': LivewirePageController9b0041085e29cc730d8cb550d3e52c47,
    '/cpanel/password/reset': LivewirePageController5b6d16dd5880774a2073d6d8f40e8d6a,
    '/cpanel/password/reset/{token}': LivewirePageControllerc2e006f3b0292a7f852f0b0ce64b2cb1,
    '/cpanel/initialize': LivewirePageController9ac4133ebf5c22476faa53995bad1ed0,
    '/cpanel/forbidden': LivewirePageControllere6b900af09e258a385c781aec62a1e06,
    '/cpanel/dashboard': LivewirePageController585d8d71d5ca7c146c5b972df0f0ed67,
    '/cpanel/profile': LivewirePageControllera755758d0871b6f8cf208b1ee989fae9,
    '/cpanel/setting/general': LivewirePageController9db14a4faa4b7ebca75929f0a81a970b,
    '/cpanel/setting/appearance': LivewirePageController296c5197559ab5208102e88c18218e72,
    '/cpanel/setting/locations': LivewirePageController6635fb945be041897598a4cdb9a45dec,
    '/cpanel/setting/locations/create': LivewirePageController3d615b7997387c4793b40aa61dc8a21f,
    '/cpanel/setting/locations/{inventory}/edit': LivewirePageController7e7fe047cdd940f563f0cc18680329fe,
    '/cpanel/setting/legal': LivewirePageController500d8ce6c60276d2fdf10cbe4edf6873,
    '/cpanel/setting/analytics': LivewirePageControlleraa1df9d3315f673cccfd46a0e3776b1f,
    '/cpanel/setting/channels': LivewirePageController823e0864cbfcd8a47d2a9305e501ea89,
    '/cpanel/setting/payment-methods': LivewirePageControllerb4d44774dded524e0395af517023f390,
    '/cpanel/setting/carriers': LivewirePageControllerba86bc8dbb846d0dbb8d8e513e00e7dd,
    '/cpanel/setting/zones': LivewirePageController7e959f53ed6b14113fc63c70108bae64,
    '/cpanel/setting/taxes': LivewirePageController07816d54f01a66865f01c8c187457ead,
    '/cpanel/setting/currencies': LivewirePageController6df012a1b428c06ed35ec613d67a9e00,
    '/cpanel/setting/webhooks': LivewirePageControllerec2a7ba0a02cc00223755365f1eec503,
    '/cpanel/setting/team': LivewirePageController64cfde4e4dfe49a6f15bfbf73b9f7866,
    '/cpanel/setting/team/roles/{role}': LivewirePageControllerf55c2bd6d8bdee2ff6c1c6e109b98e35,
    '/cpanel/customers': LivewirePageController35dc1275b388029f00d9bcdd0b5adb7e,
    '/cpanel/customers/create': LivewirePageController64868e66e2cbba7c34514ea3ee7bf8fe,
    '/cpanel/customers/{user}/show': LivewirePageController9dfa2002759f4096a239f95bf6c2b46d,
    '/cpanel/orders': LivewirePageController7c03901bb64e65b3cd46ab8fa0c9a4eb,
    '/cpanel/orders/shipments': LivewirePageController367b78de9753c6055b68823aa54fcb3b,
    '/cpanel/orders/abandoned-carts': LivewirePageController39e8e91f2eb96dfc808648887f45f682,
    '/cpanel/orders/{order}/detail': LivewirePageControllerf7abf1865b77dce52c322d41ba5b8155,
    '/cpanel/products': LivewirePageControllerba4d971e38b1bc5188b75723ffae2538,
    '/cpanel/products/{product}/edit': LivewirePageController5e6be45ae12b00cfe90aee6a481b4c17,
    '/cpanel/products/{product}/edit/media': LivewirePageControllera20b2461df92e11600f6f3759b9786e5,
    '/cpanel/products/{product}/edit/attributes': LivewirePageController328699919ee949a22542508bf550d289,
    '/cpanel/products/{product}/edit/variants': LivewirePageControllera0cfe705c3d05630fcd20b3f871d36e6,
    '/cpanel/products/{product}/edit/variants/{variant}': LivewirePageControllerbeb96d2b1846075729e6a163c643920a,
    '/cpanel/products/{product}/edit/inventory': LivewirePageController29243b7ae44dd8d6833d1a431169330f,
    '/cpanel/products/{product}/edit/pricing': LivewirePageController957a1147a3dc2c9abe3fd4955c991870,
    '/cpanel/products/{product}/edit/shipping': LivewirePageController1376ec20baaa13f484c5b81fee47e102,
    '/cpanel/products/{product}/edit/files': LivewirePageController70af48a542748564b1f8eb1cc4bf3814,
    '/cpanel/products/{product}/edit/seo': LivewirePageControllereb5e5201c91c3c481272a6e0482e33c9,
    '/cpanel/products/{product}/edit/related': LivewirePageControllera7c01121055dd6961e9d3a6038b55c6a,
    '/cpanel/products/attributes': LivewirePageControllerda2a8098d63efbdd3c60f607b3c6c707,
    '/cpanel/products/tags': LivewirePageController03975106eeb6cf71e849fa2896abd9f1,
    '/cpanel/brands': LivewirePageControllerc2117340e48f6b7d02f66b304fbe65fd,
    '/cpanel/categories': LivewirePageController2ab45b2856eb3dc1254022ab0cd4cfd5,
    '/cpanel/collections': LivewirePageControllerace5ca34b1b67d163a9403e6c33e5798,
    '/cpanel/collections/{collection}/edit': LivewirePageControlleraea69969336694e302a786d7a17a991f,
    '/cpanel/campaigns': LivewirePageController25df21ef6c8202b526cacdd2b9da8d46,
    '/cpanel/campaigns/create': LivewirePageController468ce0be8dd63c471212fc8a6aed72d2,
    '/cpanel/campaigns/{record}/edit': LivewirePageControllerbc2850edcd4c4825a56102674d11a7a9,
    '/cpanel/discounts': LivewirePageControllerc43f397c18348b40c410c4ad490336c1,
    '/cpanel/discounts/{record}/edit': LivewirePageControllercf3b0e39a77276f8e34d39c13bb0844f,
    '/cpanel/reviews': LivewirePageController9ff15722299988959e0c18911d680164,
}

export default LivewirePageController