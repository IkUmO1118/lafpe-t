import { Outlet } from "react-router-dom";
import Header from "./Header";
import Footer from "./Footer";

function AppLayout() {
  return (
    <div className="flex min-h-screen flex-col bg-neutral-50">
      <Header />
      <main className="h-full flex-1 bg-neutral-50">
        <Outlet />
      </main>
      <Footer />
    </div>
  );
}

export default AppLayout;
