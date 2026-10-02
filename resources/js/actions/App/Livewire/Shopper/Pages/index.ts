import PendingProducts from './PendingProducts'
import BlacklistedProducts from './BlacklistedProducts'
import HomepageBanners from './HomepageBanners'
import MenuItems from './MenuItems'
import News from './News'
const Pages = {
    PendingProducts: Object.assign(PendingProducts, PendingProducts),
BlacklistedProducts: Object.assign(BlacklistedProducts, BlacklistedProducts),
HomepageBanners: Object.assign(HomepageBanners, HomepageBanners),
MenuItems: Object.assign(MenuItems, MenuItems),
News: Object.assign(News, News),
}

export default Pages