const Cookie = process.client ? require("js-cookie") : undefined;

export default function ({ store, redirect, route }) {
    // If the user is not authenticated
    let cookie = Cookie.get("auth_user");
    if (!cookie) {
        const path = encodeURIComponent(route.path);
        return redirect(`/login?r=${path}`);
    }
}
