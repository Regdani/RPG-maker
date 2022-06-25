import "./options";
import App from "gold-admin/app.svelte";
import ListManager from "gold-admin/app/list-manager";
import MenuItem from "gold-admin/app/menu-item";
import PageManager from "gold-admin/app/page-manager";
import AuthApi from "gold-admin/auth/auth-api";
import FaIcon from "gold-admin/fa-icon";
import UserForm from "src/ui/user/user-form";
import DashboardPage from "src/ui/dashboard/dashboard-page";
import UserList from "./ui/user/user-list";
import type I_User from "gold-admin/auth/user.interface";
import FormPage from "gold-admin/form/form-page";
import MapPage from "src/ui/map/map-page";
import TileList from "src/ui/map/tile-list";
import PoiList from "src/ui/map/poi-list";

window.addEventListener('load', () => {

		let pageManager = new PageManager();
		let listManager = new ListManager();
		let authApi = new AuthApi("/api/auth", () => {
			pageManager.add(new DashboardPage());
			listManager.add(new UserList());
		});

		function menu(user: I_User | null) {
			return [
				new MenuItem("Dashboard", FaIcon.s("dice-d6"), () => {pageManager.add(new DashboardPage())}),
				new MenuItem("Users", FaIcon.s("users"), () => {listManager.add(new UserList())}),
				new MenuItem("Tiles", FaIcon.s("layer-group"), () => {listManager.add(new TileList())}),
				new MenuItem("POIs", FaIcon.s("thumbtack"), () => {listManager.add(new PoiList())}),
				new MenuItem("Map", FaIcon.s("map"), () => {pageManager.add(new MapPage())})
			]
		}

		function userMenu(user: I_User | null) {
			return [new MenuItem("Me", FaIcon.s("user"), () => {pageManager.add(new FormPage(new UserForm(user!.id)))})]
		}

		new App({target: document.body, props: {pageManager, listManager, authApi, menu, userMenu}})
	}
)
