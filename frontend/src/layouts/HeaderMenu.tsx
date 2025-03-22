import { NavLink, useNavigate } from "react-router-dom";
import { Button } from "../components/Button";
import { useGetSession } from "../hooks/useSession";

interface HeaderMenuProps {
  gap?: string;
  rounded?: string;
}

function HeaderMenu({ gap, rounded }: HeaderMenuProps) {
  const navigate = useNavigate();

  const hasKarte = useGetSession("karte");

  return (
    <li className={`flex items-center ${gap}`}>
      <NavLink to="/home" className="text-sm text-neutral-700 hover:underline">
        ホーム
      </NavLink>
      <NavLink
        to="/diagnosis"
        className="text-sm text-neutral-700 hover:underline"
      >
        性能診断
      </NavLink>
      <NavLink
        to="/feedback"
        className="text-sm text-neutral-700 hover:underline"
      >
        ご意見・ご感想
      </NavLink>

      <Button
        variant="fillPrimary"
        size="sm"
        className={rounded}
        onClick={() =>
          hasKarte ? navigate("/result") : navigate("/diagnosis")
        }
      >
        {hasKarte ? "診断結果" : "診断する"}
      </Button>
    </li>
  );
}

export default HeaderMenu;
