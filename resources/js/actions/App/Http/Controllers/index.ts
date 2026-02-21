import DashboardController from './DashboardController'
import FavoriteTeamController from './FavoriteTeamController'
import TeamController from './TeamController'
import Settings from './Settings'

const Controllers = {
    DashboardController: Object.assign(DashboardController, DashboardController),
    FavoriteTeamController: Object.assign(FavoriteTeamController, FavoriteTeamController),
    TeamController: Object.assign(TeamController, TeamController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers