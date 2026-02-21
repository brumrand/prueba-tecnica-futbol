import DashboardController from './DashboardController'
import FavoriteTeamController from './FavoriteTeamController'
import Settings from './Settings'

const Controllers = {
    DashboardController: Object.assign(DashboardController, DashboardController),
    FavoriteTeamController: Object.assign(FavoriteTeamController, FavoriteTeamController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers